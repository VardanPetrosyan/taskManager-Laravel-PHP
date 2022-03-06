<?php

namespace App\Http\Controllers;


use App\Contact;
use App\Positions;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function change(Request $request){
        $imageName = null;
        if($request['img'] != "undefined"){
            $imageName = time().'.'.$request['img']->getClientOriginalExtension();
            $dirName = base_path() . '/public/assets/images/upload/';
            $request['img']->move($dirName, $imageName);
        }

        $userPass = User::find($request["id"]);
        $password = $userPass->password;

        if($userPass && Hash::check($request["currentPassword"], $password) ){
            $password = $request['newPassword'];
            User::where(['id'=>$request['id']])->update(["password" => bcrypt($password) ]);
        }

        if($imageName){
            User::where(['id'=>$request['id']])->update(['img'=>$imageName, "password" => $password ]);
        }

        if($request['name'] != null && $request['name'] != "" && $request['name'] != "undefined"){
//        dd($request);
            User::where(['id'=>$request['id']])->update(['name'=>$request['name'] ]);
        }

        $userer = User::find($request["id"]);
        

        return response()->json([
            'newName'=>$userer->name,
            'newImg'=>$userer->img,
        ]);

    }

    public function getUsernames($id){
        $users = DB::table('users')
            ->select('id','name','categoryStructure_id AS categoryStructure')
            ->where('status','!=', 'deleted')
            ->get();
//        $users = User::all('id','name','categoryStructure_id AS categoryStructure');
        $position = Positions::query()->where('id',$id)->first();
        return response()->json(['data'=>$users,'position'=>$position]);
    }
    public function getUsers(Request $request){
        $id = $request['categoryStructure_id'];
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
        $users = DB::table('users')
            ->select('id','name','categoryStructure_id AS categoryStructure','email','status','position')
            ->where('status','!=', 'deleted')
            ->where('status','!=', 'admin')
            ->whereIn('categoryStructure_id',$arrId)
            ->get();
        $position = DB::table('positions')
            ->get();

        return response()->json(['data'=>$users,'position'=>$position]);
    }

    public function select(Request $request){

        $user = User::where(['id'=>$request['id']])->first();
        $contact = Contact::orderBy("id","DESC")->first();
        $position = DB::table('positions')->where('id',$user->position)->first();
        	
	return response()->json(['user'=>$user,'contact'=>$contact,'position'=>$position]);

    }
    public function updateUsers(Request $request){
        $newData = $request->post('newData');
        $userId = $newData['id'];
        $user = \App\Models\User::find($userId);
    
        $user->name = $newData['name'];
        $user->email = $newData['email'];
        $user->status = $newData['status'];
        $user->position = $newData['position'];
        $user->categoryStructure_id = $newData['categoryStructure'];
        
        if (!is_null($newData['password'])) {
            $password = bcrypt($newData['password']);
            $user->password = $password;
        }
        $user->save();
        
    
        return response()->json(['success'=>true]);
        
    }
    public function deleteUsers(Request $request){
        $userId = $request->post('userId');
        $user = \App\Models\User::find($userId);
    
        $user->delete();
    
        return response()->json(['success'=>true]);
        
    }
    public function addUsers(Request $request){
        $data = $request->post('data');
        $users = DB::table('users')->get();
        foreach ($users as $user){
            if($data['email'] == $user->email ){
                $text = 'Էլ հասցեն արդեն գրանցված է';
               return response()->json(['error' => $text]);
            }
        }
        
        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => $data['status'],
            'categoryStructure_id' => $data['categoryStructure'],
            'position' => $data['position'],
            'img' => 'default-user.jpg',
    
        ]);
        
        return response()->json(['success'=>true]);
        
    }



}
