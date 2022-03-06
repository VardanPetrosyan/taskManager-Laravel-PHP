<?php

namespace App\Http\Controllers\Admin;

use App\Exports\FurnituresExport;
use App\Exports\FurnituresIDCategory;
use App\Exports\FurnituresIdExport;
use App\Exports\HistoryExport;
use App\FurnHistory;
use App\Furnitures;
use App\Imports\FurnituresImport;
use App\Models\Category;
use App\Models\Units;
use App\Models\User;
use App\Imports\ProductsImport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use File;




class FurnituresController extends Controller
{
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::where('story',2)->get();
        $categoriesStructure = DB::table("category_structures")
            ->where("is_deleted", 'false')
            ->where("parent_category_id", null)
            ->get();
        $users = User::select("users.*", "category_structures.category AS schoolName", "positions.name AS positionName")
            ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id")
            ->join("positions", "positions.id", "=", "users.position")
            ->get();

        $filters = [
            'in_use',
            'unnecessary',
        ];

        $furnitures = Furnitures::query()
            ->select("furnitures.*", "category.name AS categoryName", "category_structures.category AS schoolName", "users.name AS username")
            ->join("category", "category.id", "=", "furnitures.category_id")
            ->join("category_structures", "category_structures.id", "=", "furnitures.categoryStructure_id")
            ->join("users", "users.id", "=", "furnitures.user_id")
            ->where('category_structures.is_deleted', '=','false')
            ->where('category.story','=','2')
            ->orderBy('furnitures.id', 'desc');
        if (in_array($request->get('filter'), $filters)) {
            $furnitures->where('furnitures.status', $request->get('filter'));
            
        }
        
        
        Session::put('filter_furnitures', $request->get('filter'));
        
        
        if ($request->get('categoriesStructureView') != null) {
            $id = $request->get('categoriesStructureView');
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
            $furnitures->whereIn('furnitures.categoryStructure_id', $arrId);
            Session::put('filter_furnitures_structureCategory', $arrId);
        }
        
        
        Session::put('filter_furnitures_is_structureCategory', $request->get('categoriesStructureView'));
        
        
        if($request->get('UsersView') != null){
            $idUser = $request->get('UsersView');
            $furnitures->where('user_id', '=',$idUser);
            Session::put('filter_furnitures_user', $idUser);
        }
        Session::put('filter_furnitures_is_user', $request->get('UsersView'));
        
        
        
        
        $furnitures->where('furnitures.status', '!=', 'ordered');
        $furnitures->where('furnitures.status', '!=', 'sended');
        $furnitures = $furnitures->get();
        
//        dd($furnitures);
        return view('admin.furnitures')->with([
            'furnitures' => $furnitures,
            'categories' => $categories,
            'categoriesStructure' => $categoriesStructure,
            'users' => $users,
        ]);
    }

    public function ordered(Request $request)
    {
//        $categories = Category::where('story','2')->get();
//        $schools =  $schools = DB::table("school")->get();
//        $users = User::where('position',2)
//            ->select("users.*","school.name AS schoolName")
//            ->join("school","school.id","=", "users.school_id")
//            ->get();

        $filters = [
            'ordered',
            'sended',
        ];

        $furnitures = Furnitures::query()
            ->select("furnitures.*", "category.name AS categoryName", "category_structures.category AS schoolName", "users.name AS username")
            ->with('orderedCategoryStructure')
            ->with('sendedCategoryStructure')
            ->join("category", "category.id", "=", "furnitures.category_id")
            ->join("category_structures", "category_structures.id", "=", "furnitures.categoryStructure_id")
            ->join("users", "users.id", "=", "furnitures.user_id")
            ->where('category.story','=','2')
            ->orderBy('furnitures.id', 'desc');
        if (in_array($request->get('filter'), $filters)) {
            $furnitures->where('furnitures.status', $request->get('filter'));
        }

        $furnitures->where('furnitures.status', '!=', 'in_use');
        $furnitures->where('furnitures.status', '!=', 'unnecessary');

        $furnitures = $furnitures->get();
//        dd($furnitures);
        return view('admin.furnituresOrdered')->with([
            'furnitures' => $furnitures,
        ]);

    }

    public function getType($type)
    {

        switch ($type) {
            case "order":
                return "Գրանցվել է պատվեր";
                break;
            case "cancel_order":
                return "Պատվերը Չեղարկվել է";
                break;
            case "admin_confirm":
                return "Ադմինը Հաստատել է";
                break;
            case "admin_disapprove":
                return "Ադմինը Չեղարկել է";
                break;
            case "admin_decline":
                return "Ադմինը  Մերժել է";
                break;
            case "send":
                return "Պատվերը ուղարկվել է";
                break;
            case "cancel_send":
                return "Պատվերը մերժվել է";
                break;
            case "receive":
                return "Պատվերը ստացվել է";
                break;
            case "cancel_receive":
                return "Պատվերը չի ստացվել";
                break;
            case "add":
                return "Գույքի Ավելացում";
                break;
            case "delete":
                return "Գույքի լուծարում";
                break;
            case "edit":
                return "Գույքի փոփոխություն";
                break;
            default:
                return "";
                break;
        }
    }

    public function history(Request $request)
    {
        Session::put('filter_user_date', $request->get('filterByDate'));
        if($request->get('filterByDate') != null){
            $date = explode("-", $request->get('filterByDate'));
    
            $firstDate = date("Y-m-d", strtotime($date[0]));
            $secondDate = date("Y-m-d", strtotime($date[1]));
        }
        
        $UsersView = $request->get('UsersView');

        Session::put('filter_user', $request->get('UsersView'));
        $history = FurnHistory::with('user')->with('categoryStructure')->with('receiver')->get();
        $users = User::all()->where('status','!=','deleted');

        foreach ($history as $key => $item) {
            $history[$key]['typeName'] = $this->getType($item->type);
        }
        foreach ($history as $his) {
            if($his->receiver_categoryStructure_id == null){
                $his->receiver_categoryStructure_id = 0;
            }
        }
        if($UsersView != null){
            $history = $history->where('user_id',$UsersView);
        }
        if($request->get('filterByDate') != null){
            if(strtotime($firstDate) != strtotime($secondDate)){
                $history = $history
                    ->where("created_at", ">", $firstDate . " 00:00:00")
                    ->where("created_at", "<", $secondDate . " 00:00:00");
            }
    
        }
        
//        dd($firstDate);
        return view('admin.furnituresHistory')->with([
            'history' => $history,
            'users' => $users
        ]);

    }


    public function create(Request $request)
    {
        $user = User::find($request->post('responsible'));
        if(($request->post('count') == null || $request->post('count') == 0) && ($request->post('countUnnecessary') == null || $request->post('countUnnecessary') == 0)){
            $validatedData = $this->validate($request, [
                'count' => 'required',
            ]);
        }
        $validatedData = $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'category' => 'required',
            'responsible' => 'required',
        ]);
        
        if(($request->post('count') != null || $request->post('count') != 0) && ($request->post('countUnnecessary') == null || $request->post('countUnnecessary') == 0)){
//            dd(1);
            $furniture = Furnitures::where('name', $request->post('name'))
                ->where('category_id', $request->post('category'))
                ->where('code', $request->post('code'))
                ->where('user_id', $request->post('responsible'))
                ->where('categoryStructure_id', $request->post('categoriesStructure'))
                ->where('status', 'in_use')
                ->first();
    
            if ($furniture) {
                $furniture->count += $request->post('count');
                $furniture->save();
            } else {
                $furniture = Furnitures::create([
                    'name' => $request->post('name'),
                    'category_id' => $request->post('category'),
                    'user_id' => $request->post('responsible'),
                    'count' => $request->post('count'),
                    'categoryStructure_id' => $request->post('categoriesStructure'),
                    'description' => $request->post('description'),
                    'status' => 'in_use',
                    'code' => $request->post('code')
                ]);
            }
        }elseif (($request->post('count') == null || $request->post('count') == 0) && ($request->post('countUnnecessary') != null || $request->post('countUnnecessary') != 0)){
//            dd(2);
            $furniture = Furnitures::where('name', $request->post('name'))
                ->where('category_id', $request->post('category'))
                ->where('code', $request->post('code'))
                ->where('user_id', $request->post('responsible'))
                ->where('categoryStructure_id', $request->post('categoriesStructure'))
                ->where('status', 'unnecessary')
                ->first();
    
            if ($furniture) {
                $furniture->count += $request->post('countUnnecessary');
                $furniture->save();
            } else {
                $furniture = Furnitures::create([
                    'name' => $request->post('name'),
                    'category_id' => $request->post('category'),
                    'user_id' => $request->post('responsible'),
                    'count' => $request->post('countUnnecessary'),
                    'categoryStructure_id' => $request->post('categoriesStructure'),
                    'description' => $request->post('description'),
                    'status' => 'unnecessary',
                    'code' => $request->post('code')
                ]);
            }
        }else{
            $furnitureUnnecessary = Furnitures::where('name', $request->post('name'))
                ->where('category_id', $request->post('category'))
                ->where('code', $request->post('code'))
                ->where('user_id', $request->post('responsible'))
                ->where('categoryStructure_id', $request->post('categoriesStructure'))
                ->where('status', 'unnecessary')
                ->first();
    
            if ($furnitureUnnecessary) {
                $furnitureUnnecessary->count += $request->post('countUnnecessary');
                $furnitureUnnecessary->save();
            } else {
                $furnitureUnnecessary = Furnitures::create([
                    'name' => $request->post('name'),
                    'category_id' => $request->post('category'),
                    'user_id' => $request->post('responsible'),
                    'count' => $request->post('countUnnecessary'),
                    'categoryStructure_id' => $request->post('categoriesStructure'),
                    'description' => $request->post('description'),
                    'status' => 'unnecessary',
                    'code' => $request->post('code')
                ]);
            }
            $furnitureInUse = Furnitures::where('name', $request->post('name'))
                ->where('category_id', $request->post('category'))
                ->where('code', $request->post('code'))
                ->where('user_id', $request->post('responsible'))
                ->where('categoryStructure_id', $request->post('categoriesStructure'))
                ->where('status', 'in_use')
                ->first();
    
            if ($furnitureInUse) {
                $furnitureInUse->count += $request->post('count');
                $furnitureInUse->save();
            } else {
                $furnitureInUse = Furnitures::create([
                    'name' => $request->post('name'),
                    'category_id' => $request->post('category'),
                    'user_id' => $request->post('responsible'),
                    'count' => $request->post('count'),
                    'categoryStructure_id' => $request->post('categoriesStructure'),
                    'description' => $request->post('description'),
                    'status' => 'in_use',
                    'code' => $request->post('code')
                ]);
            }
        }
        
        return back();
    }

    public function delete(Request $request)
    {
        $furniture = Furnitures::find($request->post('furId'));

        if ($furniture->count == $request->post('count')) {
            $furniture->delete();
        } else {
            $furniture->count -= $request->post('count');
            $furniture->save();
        };
        return back();
    }

    public function changeStatus(Request $request)
    {
        $furniture = Furnitures::find($request->post('furId'));

        if ($furniture->count == $request->post('count')) {
            
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
            $furniture->count -= $request->post('count');
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
                $otherFur->count += $request->post('count');
                $otherFur->save();
            } else {
                $newFur = Furnitures::create([
                    'code' => $furniture->code,
                    'name' => $furniture->name,
                    'category_id' => $furniture->category_id,
                    'user_id' => $furniture->user_id,
                    'count' => $request->post('count'),
                    'categoryStructure_id' => $furniture->categoryStructure_id,
                    'status' => $newstatus,
                ]);
            }
        };
        return back();
    }


    public function edit($id)
    {

        $categories = Category::where('story',2)->get();
        $categoriesStructure = $categoriesStructure = DB::table("category_structures")
            ->where('is_deleted', 'false')
            ->where('parent_category_id', '=', null)
            ->get();

//        dd($schools);
//        $users = User::select("users.*","category_structures.category AS schoolName")
//            ->join("category_structures","category_structures.id","=", "users.categoryStructure_id")
//            ->get();
        $users = User::select("users.*", "category_structures.category AS schoolName", "positions.name AS positionName")
            ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id")
            ->join("positions", "positions.id", "=", "users.position")
            ->get();


        $idCategoryStructure = DB::table('furnitures')->select('categoryStructure_id')->where('id', $id)->value('categoryStructure_id');
        $categoriesStructureForUpdete = DB::table("category_structures")->where('is_deleted', 'false')->where('id', $idCategoryStructure)->get();
        $furniture = Furnitures::query()
            ->select("furnitures.*", "category.name AS categoryName", "category_structures.category AS schoolName", "users.name AS username")
            ->join("category", "category.id", "=", "furnitures.category_id")
            ->join("category_structures", "category_structures.id", "=", "furnitures.categoryStructure_id")
            ->join("users", "users.id", "=", "furnitures.user_id")
            ->where('furnitures.id', $id)
            ->where('category_structures.is_deleted','false')
            ->where('category.story','2')
            ->first();

        return view('admin.furniture_edit')->with([
            'categoriesStructureForUpdete' => $categoriesStructureForUpdete,
            'furniture' => $furniture,
            'categories' => $categories,
            'categoriesStructure' => $categoriesStructure,
            'users' => $users,
        ]);
    }
    public function transfer($id)
    {
        
        $categoriesStructure = $categoriesStructure = DB::table("category_structures")
            ->where('is_deleted', 'false')
            ->where('parent_category_id', '=', null)
            ->get();

        $users = User::select("users.*", "category_structures.category AS schoolName", "positions.name AS positionName")
            ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id")
            ->join("positions", "positions.id", "=", "users.position")
            ->get();
        
        
        $idCategoryStructure = DB::table('furnitures')->select('categoryStructure_id')->where('id', $id)->value('categoryStructure_id');
        $categoriesStructureForUpdete = DB::table("category_structures")->where('is_deleted', 'false')->where('id', $idCategoryStructure)->get();
        $furniture = Furnitures::query()
            ->select("furnitures.*", "category.name AS categoryName", "category_structures.category AS schoolName", "users.name AS username")
            ->join("category", "category.id", "=", "furnitures.category_id")
            ->join("category_structures", "category_structures.id", "=", "furnitures.categoryStructure_id")
            ->join("users", "users.id", "=", "furnitures.user_id")
            ->where('furnitures.id', $id)
            ->where('category_structures.is_deleted','false')
            ->where('category.story','2')
            ->first();
        
        return view('admin.furniture_transfer')->with([
            'categoriesStructureForUpdete' => $categoriesStructureForUpdete,
            'furniture' => $furniture,
            'categoriesStructure' => $categoriesStructure,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $furniture = Furnitures::find($id);
        $user = User::find($request->post('responsible'));

        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'category' => 'required',
            'responsible' => 'required',
            'count' => 'required',
            'categoriesStructure' => 'required',
        ]);
        if($furniture->status == 'unnecessary'){
            $newStatus = 'in_use';
        }else{
            $newStatus = 'unnecessary';
        }
        $furnitureDublicate = Furnitures::where('name',$furniture->name)
            ->where('code',$furniture->code)
            ->where('category_id',$furniture->category_id)
            ->where('user_id',$furniture->user_id)
            ->where('categoryStructure_id',$furniture->categoryStructure_id)
            ->where('status',$newStatus)
            ->first();
//        dd($furnitureDublicate);
        
        
        $furniture->name = $request->post('name');
        $furniture->code = $request->post('code');
        $furniture->category_id = $request->post('category');
        $furniture->user_id = $request->post('responsible');
        $furniture->count = $request->post('count');
        $furniture->categoryStructure_id = $request->post('categoriesStructure');
        $furniture->description = $request->post('description');
        $furniture->save();
        if(isset($furnitureDublicate)){
            $furnitureDuplicateUpdate = Furnitures::find($furnitureDublicate->id);
            $furnitureDuplicateUpdate->name = $request->post('name');
            $furnitureDuplicateUpdate->code = $request->post('code');
            $furnitureDuplicateUpdate->category_id = $request->post('category');
            $furnitureDuplicateUpdate->user_id = $request->post('responsible');
            $furnitureDuplicateUpdate->categoryStructure_id = $request->post('categoriesStructure');
            $furnitureDuplicateUpdate->description = $request->post('description');
            $furnitureDuplicateUpdate->save();
        }
    
    
        return back();
    }
    public function updateTransfer(Request $request, $id)
    {
        $furniture = Furnitures::find($id);
        $user = User::find($request->post('responsible'));
        $this->validate($request, [
            'responsible' => 'required',
            'count' => 'required',
            'categoriesStructure' => 'required',
        ]);
        $furnitureDublicate = Furnitures::where('name',$furniture->name)
            ->where('category_id',$furniture->category_id)
            ->where('user_id', $request->post('responsible'))
            ->where('categoryStructure_id',$request->post('categoriesStructure'))
            ->where('status','unnecessary')
            ->first();
        if(isset($furnitureDublicate)){
            $furnitureDuplicateUpdate = Furnitures::find($furnitureDublicate->id);
            $furnitureDuplicateUpdate->count += $request->post('count');
            $furnitureDuplicateUpdate->save();
        }else{
            $furnitureDublicateForCode = Furnitures::where('name',$furniture->name)
                ->where('category_id',$furniture->category_id)
                ->where('user_id', $request->post('responsible'))
                ->where('categoryStructure_id',$request->post('categoriesStructure'))
                ->where('status','in_use')
                ->first();
            if(isset($furnitureDublicateForCode)){
                Furnitures::create([
                    'code' => $furnitureDublicateForCode->code,
                    'name' => $furniture->name,
                    'image' => $furniture->image,
                    'description' => $furniture->description,
                    'status' => 'unnecessary',
                    'count' => $request->post('count'),
                    'user_id' => $request->post('responsible'),
                    'categoryStructure_id' => $request->post('categoriesStructure'),
                    'category_id' => $furniture->category_id
                ]);
            }else{
                Furnitures::create([
                    'code' => $furniture->code,
                    'name' => $furniture->name,
                    'image' => $furniture->image,
                    'description' => $furniture->description,
                    'status' => 'unnecessary',
                    'count' => $request->post('count'),
                    'user_id' => $request->post('responsible'),
                    'categoryStructure_id' => $request->post('categoriesStructure'),
                    'category_id' => $furniture->category_id
                ]);
            }
        }
        $furniture->count -= $request->post('count');
        $furniture->save();
        $furnDelete = Furnitures::where('count',0)->delete();
        
        
        return redirect()->route('admin_furniture');
    }

    public function approve(Request $request)
    {
        $furniture = Furnitures::find($request->post('furnId'));
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
        return back();
    }

    public function disapprove(Request $request)
    {
        $furniture = Furnitures::find($request->post('furnId'));
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

        return back();
    }

    public function cancelOrder(Request $request)
    {
        $furniture = Furnitures::find($request->post('furnId'));

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
//


        return back();
    }
    public function uploadFile(Request $request){

        if($request->hasFile('file')){
            $name = $request->file->getClientOriginalName();
            $extension = File::extension($name);

            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
//                dd($request);
                $request->file->move(storage_path("app"), $name);
                $path = storage_path("app/" . $name);

                $data = Excel::import(new FurnituresImport(), $name);
//                dd($data);
                unlink($path);

                return back();

            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
                return back();
            }
        }
        return back();
    }
    public function downloadId(){
        return Excel::download(new FurnituresIdExport(), 'ID-ների ցուցակ(Պատասխանատու,Կառույց).xlsx');
    }
    public function downloadIdCategory(){
        return Excel::download(new FurnituresIDCategory(), 'ID-ների ցուցակ(Կատեգորիա).xlsx');
    }
    public function exportFurnitures(){
        return Excel::download(new FurnituresExport(), 'Գույքի ցանկ.xlsx');
    }
    public function exportHistory(){
        return Excel::download(new HistoryExport(), 'Գույքի պատմության ցանկ.xlsx');
    }

    //
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\Response
//     */
//    public function create(Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required',
//            'code' => 'required',
//        ]);
//
//        $product = Product::with('categoryObj')
//            ->where('code', $request->post('code'))
//            ->first();
//
//        if (!is_null($product)) {
//            if ($request->post('storage') == $product->categoryObj->story) {
//                $product->count += $request->post('count');
//                $product->save();
//            } else {
//                flash('Տվյալ ապրանքը արդեն գոյություն ունի մյուս պահեստում')->error();
//            }
//
//            return back();
//        }
//
//        $category = $request->post('category');
//        $price = $request->post('price');
//        $count = $request->post('count');
//        $description = $request->post('description');
//
//        if ($request->post('without_image') == 'without') {
//            $imageName = null;
//        } else {
//            if (!is_null($request->file('image'))) {
//                $image = $request->file('image');
//                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
//                $image->move('img/products', $imageName);
//            } else {
//                $imageName = 'no-image.png';
//            }
//        }
//        if(is_null($price)){
//            $price = 0;
//        }
//
//        $product = Product::create([
//            'name' => $request->post('name'),
//            'category' => $category,
//            'price' => $price,
//            'count' => $count,
//            'code' => $request->post('code'),
//            'status' => $request->post('status'),
//            'description' => $description,
//            'image' => $imageName,
//            'unit' => $request->post('unit'),
//        ]);
//
//
//        return back();
//    }
//
//    public function active($id)
//    {
//        $product = Product::find($id);
//        $product->status = Product::STATUS_ACTIVE;
//        $product->save();
//
//        return back();
//    }
//
//    public function passive($id)
//    {
//        $product = Product::find($id);
//        $product->status = Product::STATUS_PASSIVE;
//        $product->save();
//
//        return back();
//    }
//
//    public function edit($id)
//    {
//        $product = Product::find($id);
//        $categories = Category::all();
//        $units = Units::all();
//        return view('admin.edit')->with([
//            'product' => $product,
//            'categories' => $categories,
//            'units' => $units,
//        ]);
//
//    }
//
//    public function delete($id)
//    {
//        $product = Product::find($id);
//        $product->delete();
//        return back();
//
//    }
//
//    public function update(Request $request)
//    {
//        $this->validate($request, [
//            'name' => 'required',
//        ]);
//        $productId = $request->post('product_id');
//
//        $product = Product::find($productId);
//
//
//
//        if(!is_null($request->file('avatar'))) {
//            $image = $request->file('avatar');
//            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
//            $image->move('img/products', $imageName);
//            $product->image = $imageName;
//        }
//
//        $product->name = $request->post('name');
//        $product->category = $request->post('category');
//        $product->description = $request->post('description');
//        $product->price = $request->post('price');
//        $product->status = $request->post('status');
//        $product->code = $request->post('code');
//        $product->top = $request->top?1:0;
//        $product->count = $request->post('count');
//        $product->unit = $request->post('unit');
//        $product->save();
//
//        return back();
//    }
//
//    public function showActive ()
//    {
//        $product = Product::query()
//            ->select("products.*","category.name AS categoryName")
//            ->join("category","category.id","=","products.category")
//            ->where('products.status', Product::STATUS_ACTIVE)
//            ->get();
//
//        return view('admin.product_active', [
//            'products' => $product,
//        ]);
//    }
//
//    public function showPassive ()
//    {
//        $product = Product::query()
//            ->select("products.*","category.name AS categoryName")
//            ->join("category","category.id","=","products.category")
//            ->where('products.status', Product::STATUS_PASSIVE)
//            ->get();
//
//        return view('admin.product_passive', [
//            'products' => $product,
//        ]);
//    }
//
//    public function showReserved ()
//    {
//        $product = Product::query()
//            ->select("products.*","category.name AS categoryName")
//            ->join("category","category.id","=","products.category")
//            ->where('products.status', Product::STATUS_RESERVE)
//            ->get();
//
//        return view('admin.product_reserved', [
//            'products' => $product,
//        ]);
//    }
//
//    public function destroy($id)
//    {
//        Product::find($id)->update(['status' => 'passive']);
//        return redirect()->route('products.index');
//    }
//
//    public function uploadFile(Request $request){
//
//        if($request->hasFile('file')){
//            $name = $request->file->getClientOriginalName();
//            $extension = File::extension($name);
//
//            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
////                dd($request);
//                $request->file->move(storage_path("app"), $name);
//                $path = storage_path("app/" . $name);
//
//                $data = Excel::import(new ProductsImport(), $name);
////                dd($data);
//                unlink($path);
//
//                return back();
//
//            }else {
//                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xls/csv file..!!');
//                return back();
//            }
//        }
//        return back();
//    }


    /*Excel::load($request['file'], function ($reader) {
//            $reader->each(function($sheet) {
//                foreach ($sheet->toArray() as $row) {
//                    dd($row);
//                }
//            });
    });

//        $rows = \Excel::load('/asset'. $request['file'])->get();
//        dd($request['file']);*/


}
