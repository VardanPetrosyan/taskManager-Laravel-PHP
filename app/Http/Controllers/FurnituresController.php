<?php

namespace App\Http\Controllers;

use App\Category;
use App\CategoryStructure;
use App\FurnHistory;
use App\Imports\FurnituresImport;
use App\Models\User;
use App\Positions;
use App\School;
use Illuminate\Http\Request;
use App\Furnitures;
use Illuminate\Support\Facades\DB;


use Maatwebsite\Excel\Facades\Excel;
use Session;
use File;

class FurnituresController extends Controller
{
    public function getFurnitures(Request $request){

        $furnitures = Furnitures::where('status','unnecessary');


        if($request->post('categories')){
            $cats = $request->post('categories');
            sort($cats);
            $furnitures = $furnitures->whereIn('category_id',$cats);
        }

        if($request->post('school')){
            $id = $request->post('school');
            $arrId = [$id];
            for($i = 0;$i<count($arrId);$i++){
                $categoryStructureId = DB::table('category_structures')->where('is_deleted', 'false')->get();
                foreach ($categoryStructureId as $categoryId){
                    if ($categoryId->parent_category_id) {
                        if($categoryId->parent_category_id == $arrId[$i]){
                            $arrId[] = $categoryId->id;
                        }
                    }
                }
            }
            $furnitures = $furnitures->whereIn('categoryStructure_id',$arrId);
        }
        if($request->post('product')){
            $cats = $request->post('product');
            sort($cats);
            $furnitures = $furnitures->whereIn('id',$cats);
        }
        $furnitures = $furnitures->get();


        return response()->json(['data'=>$furnitures]);
    }
    public function getWorkers($id){
        $workers = User::where('categoryStructure_id',$id)->get();
        return response()->json(['data'=>$workers]);
    }



    public function getMyFurnitures(Request $request){

        $sendedFurn = [];
        $orderedFurn = [];
        $myOrderedFurn= [];
        $historyFurn= [];

        $user = User::find($request->user_id);
        $position = Positions::find($user->position);
        if($position->type == 'director'){
            $id = $user->categoryStructure_id ;
            $arrId = [$id];
            for($i = 0;$i<count($arrId);$i++){
                $categoryStructureId = DB::table('category_structures')->where('is_deleted', 'false')->get();
                foreach ($categoryStructureId as $categoryId){
                    if ($categoryId->parent_category_id) {
                        if($categoryId->parent_category_id == $arrId[$i]){
                            $arrId[] = $categoryId->id;
                        }
                    }
                }
            }
            $furnitures = Furnitures::whereIn('categoryStructure_id',$arrId)->where('status','!=','ordered')
                ->get();

            $sendedFurn = Furnitures::where('sended_to_categoryStructure_id',$user->categoryStructure_id)
                ->get();

            $orderedFurn = Furnitures::where('ordered_from_categoryStructure_id',$user->categoryStructure_id)
                ->get();

            $myOrderedFurn = Furnitures::where('categoryStructure_id',$user->categoryStructure_id)->where('status','ordered')
                ->get();

            $historyFurn = FurnHistory::where('categoryStructure_id',$user->categoryStructure_id)->orWhere('receiver_categoryStructure_id',$user->categoryStructure_id)
                ->orderBy('id','desk')->get();
        }else{
            $furnitures = Furnitures::where('user_id',$request->user_id)
                ->get();
        }
        return response()->json([
            'data' => $furnitures,
            'sendedFurn' => $sendedFurn,
            'orderedFurn' => $orderedFurn,
            'myOrderedFurn' => $myOrderedFurn,
            'historyFurn' => $historyFurn,
        ]);
    }
    public function getOrderAllFurnitures(Request $request){
       
        
        $user = User::find($request->user_id);
        $position = Positions::find($user->position);
        if($position->type == 'director'){
            $id = $user->categoryStructure_id ;
            $arrId = [$id];
            for($i = 0;$i<count($arrId);$i++){
                $categoryStructureId = DB::table('category_structures')->where('is_deleted', 'false')->get();
                foreach ($categoryStructureId as $categoryId){
                    if ($categoryId->parent_category_id) {
                        if($categoryId->parent_category_id == $arrId[$i]){
                            $arrId[] = $categoryId->id;
                        }
                    }
                }
            }
            $furnitures = Furnitures::whereIn('categoryStructure_id',$arrId)->where('status','!=','in_use')->where('status','!=','unnecessary')
                ->get();
            
        
        }else{
            $furnitures = Furnitures::where('user_id',$request->user_id)
                ->get();
        }
        return response()->json([
            'data' => $furnitures
        ]);
    }
    public function confirmOrderFurnitures(Request $request){
    
    
        $furniture = Furnitures::find($request->post('furn'));
        $furniture->approved = true;
    
        FurnHistory::create([
            'name' => $furniture['name'],
            'user_id' => $furniture->user_id,
            'count' => $furniture['count'],
            'categoryStructure_id' => $furniture->categoryStructure_id,
            'receiver_categoryStructure_id' => $furniture->ordered_from_categoryStructure_id,
            'type' => FurnHistory::TYPE_ADMIN_CONFIRM,
            'description' => $furniture->description,
        ]);
    
        $furniture->save();
        return response()->json([
           'success' =>true
        ]);
    }
    public function cancelOrderFurnitures(Request $request){
    
    
        $furniture = Furnitures::find($request->post('furn'));
        $furniture->approved = false;
    
        $furniture->save();
    
        FurnHistory::create([
            'name' => $furniture['name'],
            'user_id' => $furniture->user_id,
            'count' => $furniture['count'],
            'categoryStructure_id' => $furniture->categoryStructure_id,
            'receiver_categoryStructure_id' => $furniture->ordered_from_categoryStructure_id,
            'type' => FurnHistory::TYPE_ADMIN_DISAPPROVE,
            'description' => $furniture->description,
        ]);
        return response()->json([
            'success' =>true
        ]);
    }
    public function deleteOrderFurnitures(Request $request){
    
    
        $furniture = Furnitures::find($request->post('furn'));
    
        FurnHistory::create([
            'name' => $furniture['name'],
            'user_id' => $furniture->user_id,
            'count' => $furniture['count'],
            'categoryStructure_id' => $furniture->categoryStructure_id,
            'receiver_categoryStructure_id' => $furniture->ordered_from_categoryStructure_id,
            'type' => FurnHistory::TYPE_ADMIN_DECLINE,
            'description' => $furniture->description,
        ]);
    
        $fromFurn = Furnitures::where('categoryStructure_id', $furniture->categoryStructure_id)
            ->where('status', 'unnecessary')
            ->where('name', $furniture->name)
            ->where('user_id', $furniture->user_id)
            ->first();
    
        if ($fromFurn) {
            $fromFurn->count += $furniture->count;
            $fromFurn->save();
            $furniture->delete();
        } else {
            $furniture->approved = false;
            $furniture->sended_to_categoryStructure_id = null;
            $furniture->status = 'unnecessary';
            $furniture->ordered_from_categoryStructure_id = null;
            $furniture->save();
        }
        return response()->json([
            'success' =>true
        ]);
    }
    
    
    public function deleteFurniture(Request $request){
        $furId = $request->post('furId');
        $furn = Furnitures::find($furId);


        FurnHistory::create([
            'name' => $furn->name,
            'user_id' => $furn->user_id,
            'categoryStructure_id' => $furn->categoryStructure_id,
            'count' => $furn->count,
            'type' => FurnHistory::TYPE_DELETE_FURN,
            'description' => '',
        ]);

        $furn->delete();

        return response()->json(['data'=>$furn,'success'=>true]);

    }
    public function updateStatusFurniture(Request $request){
        $dataNew = $request->post('newData');
        $dataOld = $request->post('oldData');
        $furniture = Furnitures::find($dataOld['id']);
       
        if ($furniture->count == $dataNew['count']) {
        
            if ($furniture->status == 'in_use') {
                $isFurnitureOne = Furnitures::where('name', $furniture->name)
                    ->where('code',$furniture->code)
                    ->where('status','unnecessary')
                    ->where('user_id',$furniture->user_id)
                    ->where('categoryStructure_id',$furniture->categoryStructure_id)
                    ->where('category_id',$furniture->category_id)
                    ->first();
                if(isset($isFurnitureOne)){
                    $furnitureUnnecessary = Furnitures::find($isFurnitureOne->id);
                    $furnitureUnnecessary->count += $furniture->count;
                    $furnitureUnnecessary->save();
                    $furniture->count = 0;
                }else{
                    $furniture->status = 'unnecessary';
                }
            } else {
                $isFurnitureTwo = Furnitures::where('name', $furniture->name)
                    ->where('code',$furniture->code)
                    ->where('status','in_use')
                    ->where('user_id',$furniture->user_id)
                    ->where('categoryStructure_id',$furniture->categoryStructure_id)
                    ->where('category_id',$furniture->category_id)
                    ->first();
                if(isset($isFurnitureTwo)){
                    $furnitureInUse = Furnitures::find($isFurnitureTwo->id);
                    $furnitureInUse->count += $furniture->count;
                    $furnitureInUse->save();
                    $furniture->count = 0;
                }else{
                    $furniture->status = 'in_use';
                }
            
            }
            $furniture->save();
            Furnitures::where('count',0)->delete();
        } else {
            $furniture->count -= $dataNew['count'];
            $furniture->save();
        
            if ($furniture->status == 'in_use') {
                $newstatus = 'unnecessary';
            } else {
                $newstatus = 'in_use';
            }
        
            $otherFur = Furnitures::where('name', $furniture->name)
                ->where('code',$furniture->code)
                ->where('category_id', $furniture->category_id)
                ->where('user_id', $furniture->user_id)
                ->where('categoryStructure_id', $furniture->categoryStructure_id)
                ->where('status', $newstatus)
                ->first();
        
            if ($otherFur) {
                $otherFur->count += $dataNew['count'];
                $otherFur->save();
            } else {
                $newFur = Furnitures::create([
                    'code' => $furniture->code,
                    'name' => $furniture->name,
                    'category_id' => $furniture->category_id,
                    'user_id' => $furniture->user_id,
                    'count' => $dataNew['count'],
                    'categoryStructure_id' => $furniture->categoryStructure_id,
                    'status' => $newstatus,
                    'description' => $furniture->description
                ]);
            }
        };
        
        return response()->json(['success'=>true]);
        
    }

    public function sendFurniture(Request $request){

        $furniture = $request->post('furniture');

        $furn = Furnitures::find($furniture['id']);
        $furn->sended_to_categoryStructure_id = $furn->ordered_from_categoryStructure_id;
        $furn->ordered_from_categoryStructure_id = null;
        $furn->approved = false;
        $furn->status = 'sended';
        $furn->save();
        $furn->refresh();

        FurnHistory::create([
            'name' => $furn->name,
            'user_id' => $furn->user_id,
            'categoryStructure_id' => $furn->categoryStructure_id,
            'receiver_categoryStructure_id' => $furn->sended_to_categoryStructure_id,
            'count' => $furn->count,
            'type' => FurnHistory::TYPE_SEND,
            'description' => '',
        ]);


        return response()->json(['data'=>$furn,'success'=>true]);

    }

    public function getSchoolName($id){
        return CategoryStructure::find($id)->category;
    }

    public function getUserName($id){
        return User::find($id)->name;
    }

    public function getCategoryName($id){
        return Category::find($id)->name;
    }
    

    public function getStatusName($status){
        switch ($status){
            case "in_use":
                return "Օգտագործվող";
                break;
            case "unnecessary":
                return "Չօգտագործվող";
                break;
        }
    }

    public function updateFurniture(Request $request){
        $oldData = $request->post('oldData');
        $newData = $request->post('newData');
        $furn = Furnitures::find($oldData['id']);

        $descr = 'Փոփոխվել են՝ ';

        if($furn->name != $newData['name']){
            $descr.="Անվանում: $furn->name -> ".$newData['name'].",\n ";
        }

        if($furn->description  != $newData['description']){
            $descr.="Նկարագր: $furn->description -> ".$newData['description'].",\n ";
        }

//        if($furn->status != $newData['status']){
//            $descr.="Կարգավիճակ: ".$this->getStatusName($furn->status)." -> ".$this->getStatusName($newData['status']).",\n ";
//        }

        if($furn->count != $newData['count']){
            $descr.="Քանակ: $furn->count -> ".$newData['count'].",\n ";
        }

        if($furn->user_id != $newData['user_id']){
            $descr.="Պատասխանատու: ".$this->getUserName($furn->user_id)." -> ".$this->getUserName($newData['user_id']).",\n ";
        }

        if($furn->category_id != $newData['category_id']){
            $descr.="Կատեգորիա: ".$this->getCategoryName($furn->category_id)." -> ".$this->getCategoryName($newData['category_id']).",\n ";
        }
        if($furn->categoryStructure_id != $newData['school_id']){
            $descr.="Բաժին: ".$this->getSchoolName($furn->categoryStructure_id)." -> ".$this->getSchoolName($newData['school_id']).",\n ";
        }
        if($furn->status == 'unnecessary'){
            $newStatus = 'in_use';
        }else{
            $newStatus = 'unnecessary';
        }
        $furnitureDublicate = Furnitures::where('name',$furn->name)
            ->where('code',$furn->code)
            ->where('category_id',$furn->category_id)
            ->where('user_id',$furn->user_id)
            ->where('categoryStructure_id',$furn->categoryStructure_id)
            ->where('status',$newStatus)
            ->first();
//        dd($furnitureDublicate);
    
    
        $furn->name = $newData['name'];
//        $furniture->code = $request->post('code');
        $furn->category_id = $newData['category_id'];
        $furn->user_id = $newData['user_id'];
        $furn->count = $newData['count'];
        $furn->categoryStructure_id = $newData['school_id'];
        $furn->description = $newData['description'];
        $furn->save();
        if(isset($furnitureDublicate)){
            $furnitureDuplicateUpdate = Furnitures::find($furnitureDublicate->id);
            $furnitureDuplicateUpdate->name = $newData['name'];
//            $furnitureDuplicateUpdate->code = $request->post('code');
            $furnitureDuplicateUpdate->category_id = $newData['category_id'];
            $furnitureDuplicateUpdate->user_id = $newData['user_id'];
            $furnitureDuplicateUpdate->categoryStructure_id = $newData['school_id'];
            $furnitureDuplicateUpdate->description = $newData['description'];
            $furnitureDuplicateUpdate->save();
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
//            $furn->categoryStructure_id = $newData['school_id'];
//            $furn->name = $newData['name'];
//            $furn->description = $newData['description'];
//            $furn->status = $newData['status'];
//            $furn->count = $newData['count'];
//            $furn->user_id = $newData['user_id'];
//            $furn->category_id = $newData['category_id'];
//            $furn->save();

            FurnHistory::create([
                'name' => $furn->name,
                'user_id' => $furn->user_id,
                'categoryStructure_id' => $furn->categoryStructure_id,
                'count' => $furn->count,
                'type' => FurnHistory::TYPE_EDIT_FURN,
                'description' => $descr,
            ]);

            $furn->refresh();
            
            return response()->json(['newFurn'=>$furn,'success'=>true]);


    }
    public function updateFurnitureTransfer(Request $request){
        $oldData = $request->post('oldData');
        $newData = $request->post('newData');
        $furn = Furnitures::find($oldData['id']);
        
        $furnitureDublicate = Furnitures::where('name',$furn->name)
            ->where('category_id',$furn->category_id)
            ->where('user_id', $newData['user_id'])
            ->where('categoryStructure_id',$newData['school_id'])
            ->where('status','unnecessary')
            ->first();
        if(isset($furnitureDublicate)){
            $furnitureDuplicateUpdate = Furnitures::find($furnitureDublicate->id);
            $furnitureDuplicateUpdate->count += $newData['count'];
            $furnitureDuplicateUpdate->save();
        }else{
            $furnitureDublicateForCode = Furnitures::where('name',$furn->name)
                ->where('category_id',$furn->category_id)
                ->where('user_id', $newData['user_id'])
                ->where('categoryStructure_id',$newData['school_id'])
                ->where('status','in_use')
                ->first();
            if(isset($furnitureDublicateForCode)){
                Furnitures::create([
                    'code' => $furnitureDublicateForCode->code,
                    'name' => $furn->name,
                    'image' => $furn->image,
                    'description' => $furn->description,
                    'status' => 'unnecessary',
                    'count' => $newData['count'],
                    'user_id' => $newData['user_id'],
                    'categoryStructure_id' => $newData['school_id'],
                    'category_id' => $furn->category_id
                ]);
            }else{
                Furnitures::create([
                    'code' => $furn->code,
                    'name' => $furn->name,
                    'image' => $furn->image,
                    'description' => $furn->description,
                    'status' => 'unnecessary',
                    'count' => $newData['count'],
                    'user_id' => $newData['user_id'],
                    'categoryStructure_id' => $newData['school_id'],
                    'category_id' => $furn->category_id
                ]);
            }
        }
        $furn->count -= $newData['count'];
        $furn->save();
        $furnDelete = Furnitures::where('count',0)->delete();
        
        return response()->json(['newFurn'=>$furn,'success'=>true]);
    }

    public function confirmFurniture(Request $request){
        $oldFurn = $request->post('furn');
        $furn = Furnitures::find($oldFurn['id']);

        $director = User::where('categoryStructure_id',$furn->sended_to_categoryStructure_id)->where('position',2)->first();

        $furnFrom = Furnitures::where('categoryStructure_id',$furn->sended_to_categoryStructure_id)
            ->where('status','in_use')
            ->where('user_id',$director->id)
            ->where('name',$furn->name)
            ->first();
        if($furnFrom){
            $furnFrom->count += $furn->count;
            $furnFrom->save();

            FurnHistory::create([
                'name' => $furnFrom->name,
                'user_id' => $furnFrom->user_id,
                'categoryStructure_id' => $furn->categoryStructure_id,
                'receiver_categoryStructure_id' => $furnFrom->categoryStructure_id,
                'count' => $furn->count,
                'type' => FurnHistory::TYPE_RECEIVE,
                'description' => '', //TODO::lksdfkl;af
            ]);
            $furn->delete();

        }else{
            $categoryStruvture = $furn->categoryStructure_id;

            $furn->categoryStructure_id = $furn->sended_to_categoryStructure_id;
            $furn->sended_to_categoryStructure_id = null;
            $furn->status = 'in_use';
            $furn->user_id = $director->id;
            $furn->save();

            FurnHistory::create([
                'name' => $furn->name,
                'user_id' => $furn->user_id,
                'categoryStructure_id' => $categoryStruvture,
                'receiver_categoryStructure_id' => $furn->categoryStructure_id,
                'count' => $furn->count,
                'type' => FurnHistory::TYPE_RECEIVE,
                'description' => '', //TODO::lksdfkl;af
            ]);

            $furn->refresh();
        }




        return response()->json(['newFurn'=>$furn,'success'=>true]);
    }

    public function cancelOrderFurniture(Request $request){
        $oldfurn = $request->post('furn');
        $furn = Furnitures::find($oldfurn['id']);
        $furnFrom = Furnitures::where('categoryStructure_id',$furn->categoryStructure_id)
            ->where('status','unnecessary')
            ->where('user_id',$furn->user_id)
            ->where('name',$furn->name)
            ->first();


        FurnHistory::create([
            'name' => $furn->name,
            'user_id' => $furn->user_id,
            'categoryStructure_id' => $furn->categoryStructure_id,
            'receiver_categoryStructure_id' => $furn->ordered_from_categoryStructure_id,
            'count' => $furn->count,
            'type' => FurnHistory::TYPE_CANCEL_ORDER,
            'description' => '', //TODO::lksdfkl;af
        ]);

        if($furnFrom) {
            $furnFrom->count += $furn->count;
            $furnFrom->save();
            $furnFrom->refresh();

            $furn->delete();
        }else{
         $furn->ordered_from_categoryStructure_id = null;
         $furn->approved = false;
         $furn->status = 'unnecessary';
         $furn->save();
         $furn->refresh();
        }

        return response()->json(['newFurn'=>$furn,'success'=>true]);
    }

    public function orderFurniture(Request $request){
        $furnId = $request->post('furnId');
        $furn = Furnitures::find($furnId);
        $count = $request->post('count');
        $user = User::find($request->post('user_id'));

        $orderCategoryStructureId = $user['categoryStructure_id'];



        FurnHistory::create([
            'name' => $furn->name,
            'user_id' => $furn->user_id,
            'categoryStructure_id' => $furn->categoryStructure_id,
            'receiver_categoryStructure_id' => $orderCategoryStructureId,
            'count' => $count,
            'type' => FurnHistory::TYPE_ORDER,
            'description' => '', //TODO::lksdfkl;af
        ]);

        if($count < $furn['count']){
            $furn->count -= $count;
            $furn->save();
            $furn->refresh();
        }else if($count == $furn['count']){
            $furn->delete();
        }

        Furnitures::create([
            'code' => $furn->code,
            'name' => $furn->name,
            'description' => $furn->description,
            'status' => 'ordered',
            'count' => $count,
            'user_id' => $furn->user_id,
            'category_id' => $furn->category_id,
            'ordered_from_categoryStructure_id' => intval($orderCategoryStructureId),
            'categoryStructure_id' => $furn->categoryStructure_id,
        ]);

        return response()->json(['newFurn'=>$furn,'success'=>true]);
    }

    public function addFurniture(Request $request){
    
    
        $data = $request->post('data');
        $added = [];
    
        foreach ($data as $furniture){
            $user_id = $furniture['user'];
            $user = User::find($user_id);
            if(($furniture['count'] != null || $furniture['count'] != 0) && ($furniture['countUnnecessary'] == null || $furniture['countUnnecessary'] == 0)){
//            dd(1);
                $fur = Furnitures::where('name', $furniture['name'])
                    ->where('category_id', $furniture['category'])
                    ->where('code', $furniture['code'])
                    ->where('user_id', $user_id)
                    ->where('categoryStructure_id', $furniture['categoryStructure'])
                    ->where('status', 'in_use')
                    ->first();
        
                if ($fur) {
                    $fur->count += $furniture['count'];
                    $fur->save();
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['count'],
                        'categoryStructure_id' => $fur->categoryStructure_id,
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $fur->description,
                    ]);
                } else {
                    $furn2 = Furnitures::create([
                        'name' => $furniture['name'],
                        'category_id' => $furniture['category'],
                        'user_id' => $user_id,
                        'count' => $furniture['count'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'description' => $furniture['reason'],
                        'status' => 'in_use',
                        'code' => $furniture['code'],
                        'created_at'    => date('Y-m-d H:i:s', time()),
                    ]);
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['count'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $furniture['reason'],
                    ]);
    
                    $added[] = $furn2;
                }
            }elseif (($furniture['count'] == null || $furniture['count'] == 0) && ($furniture['countUnnecessary'] != null || $furniture['countUnnecessary'] != 0)){
//            dd(2);
                $fur = Furnitures::where('name', $furniture['name'])
                    ->where('category_id', $furniture['category'])
                    ->where('code', $furniture['code'])
                    ->where('user_id', $user_id)
                    ->where('categoryStructure_id', $furniture['categoryStructure'])
                    ->where('status', 'unnecessary')
                    ->first();
        
                if ($fur) {
                    $fur->count += $furniture['countUnnecessary'];
                    $fur->save();
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['countUnnecessary'],
                        'categoryStructure_id' => $fur->categoryStructure_id,
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $fur->description,
                    ]);
                } else {
                    $furn1 = Furnitures::create([
                        'name' => $furniture['name'],
                        'category_id' => $furniture['category'],
                        'user_id' => $user_id,
                        'count' => $furniture['countUnnecessary'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'description' => $furniture['reason'],
                        'status' => 'unnecessary',
                        'code' => $furniture['code'],
                        'created_at'    => date('Y-m-d H:i:s', time()),
                    ]);
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['countUnnecessary'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $furniture['reason'],
                    ]);
    
                    $added[] = $furn1;
                }
            }else{
                $furnitureUnnecessary = Furnitures::where('name', $furniture['name'])
                    ->where('category_id', $furniture['category'])
                    ->where('code', $furniture['code'])
                    ->where('user_id', $user_id)
                    ->where('categoryStructure_id', $furniture['categoryStructure'])
                    ->where('status', 'unnecessary')
                    ->first();
        
                if ($furnitureUnnecessary) {
                    $furnitureUnnecessary->count += $furniture['countUnnecessary'];
                    $furnitureUnnecessary->save();
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['countUnnecessary'],
                        'categoryStructure_id' => $furnitureUnnecessary->categoryStructure_id,
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $furnitureUnnecessary->description,
                    ]);
                } else {
                    $furnUnnecessary = Furnitures::create([
                        'name' => $furniture['name'],
                        'category_id' => $furniture['category'],
                        'user_id' => $user_id,
                        'count' => $furniture['countUnnecessary'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'description' => $furniture['reason'],
                        'status' => 'unnecessary',
                        'code' => $furniture['code'],
                        'created_at'    => date('Y-m-d H:i:s', time()),
                    ]);
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['countUnnecessary'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $furniture['reason'],
                    ]);
    
                    $added[] = $furnUnnecessary;
                }
                $furnitureInUse = Furnitures::where('name', $furniture['name'])
                    ->where('category_id', $furniture['category'])
                    ->where('code', $furniture['code'])
                    ->where('user_id', $user_id)
                    ->where('categoryStructure_id', $furniture['categoryStructure'])
                    ->where('status', 'in_use')
                    ->first();
        
                if ($furnitureInUse) {
                    $furnitureInUse->count += $furniture['count'];
                    $furnitureInUse->save();
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['count'],
                        'categoryStructure_id' => $furnitureInUse->categoryStructure_id,
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $furnitureInUse->description,
                    ]);
                } else {
                    $furnInUse = Furnitures::create([
                        'name' => $furniture['name'],
                        'category_id' => $furniture['category'],
                        'user_id' => $user_id,
                        'count' => $furniture['count'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'description' => $furniture['reason'],
                        'status' => 'in_use',
                        'code' => $furniture['code'],
                        'created_at'    => date('Y-m-d H:i:s', time()),
                    ]);
                    FurnHistory::create([
                        'name' => $furniture['name'],
                        'user_id' => $user_id,
                        'count' => $furniture['count'],
                        'categoryStructure_id' => $furniture['categoryStructure'],
                        'type' => FurnHistory::TYPE_ADD_FURN,
                        'description' => $furniture['reason'],
                    ]);
    
                    $added[] = $furnInUse;
                }
            }
//            $fur = Furnitures::where('name',$furniture['name'])
//                ->where('user_id', $user_id)
//                ->where('status', $furniture['status'])
//                ->where('categoryStructure_id', $furniture['categoryStructure'])
//                ->first();
//
//            if($fur){
//                $fur->count += $furniture['count'];
//                $fur->save();
//
//                FurnHistory::create([
//                    'name' => $furniture['name'],
//                    'user_id' => $user_id,
//                    'count' => $furniture['count'],
//                    'categoryStructure_id' => $fur->categoryStructure_id,
//                    'type' => FurnHistory::TYPE_ADD_FURN,
//                    'description' => $fur->description,
//                ]);
//
//            }else{
//                $furn = Furnitures::create([
//                    'code' => $furniture['code'],
//                    'status'        => $furniture['status'],
//                    'user_id'       => $user_id,
//                    'name'          =>$furniture['name'],
//                    'description'   =>$furniture['reason'],
//                    'categoryStructure_id'     =>$furniture['categoryStructure'],
//                    'count'         => $furniture['count'],
//                    'category_id'   =>$furniture['category'],
//                    'created_at'    => date('Y-m-d H:i:s', time()),
//                ]);
//
//                FurnHistory::create([
//                    'name' => $furniture['name'],
//                    'user_id' => $user_id,
//                    'count' => $furniture['count'],
//                    'categoryStructure_id' => $furniture['categoryStructure'],
//                    'type' => FurnHistory::TYPE_ADD_FURN,
//                    'description' => $furniture['reason'],
//                ]);
//
//                $added[] = $furn;
//            }
        }
        
        
        
        
        
       
        return response()->json(['data'=>$added]);
    }

}
