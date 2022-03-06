<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Furnitures;
    use App\Models\Orders;
    use App\Models\Product;
    use App\Models\User;
    use App\Models\Category;
    use App\Positions;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    
    class DashboardController extends Controller
    {
        public function index()
        {
            $userUser = User::where('status', User::STATUS_USER)->count();
            $userAdmin = User::where('status', User::STATUS_ADMIN)->count();
            $archive = User::where('status', User::STATUS_DELETED)->count();
            $totalUser = $userUser + $userAdmin + $archive;
            
            $productPassive = Product::where('status', Product::STATUS_PASSIVE)->count();
            $productActive = Product::where('status', Product::STATUS_ACTIVE)->count();
            $productReserved = Product::where('status', Product::STATUS_RESERVE)->count();
            $totelProduct = $productActive + $productPassive + $productReserved;
            
            $orderPending = Orders::where('status', Orders::STATUS_PENDING)->count();
            $orderComplete = Orders::where('status', Orders::STATUS_COMPLETE)->count();
            $orderArchive = Orders::where('status', Orders::STATUS_ARCHIVE)->count();
            $orderCanceledByAdmin = Orders::where('status', Orders::STATUS_CANCELED_BY_ADMIN)->count();
            $orderCanceledByCustomer = Orders::where('status', Orders::STATUS_CANCELED_BY_CUSTOMER)->count();
            $orderTotal = $orderArchive + $orderCanceledByAdmin + $orderCanceledByCustomer + $orderComplete + $orderPending;
            $categoryTotal = Category::all()->count();
            
            return view('admin.dashboard', [
                'totalUser' => $totalUser,
                'user' => $userUser,
                'admin' => $userAdmin,
                'archive' => $archive,
                'productActive' => $productActive,
                'productPassive' => $productPassive,
                'productReserved' => $productReserved,
                'productTotal' => $totelProduct,
                'orderPending' => $orderPending,
                'orderComplete' => $orderComplete,
                'orderArchive' => $orderArchive,
                'orderCanceledByAdmin' => $orderCanceledByAdmin,
                'orderCanceledByCustomer' => $orderCanceledByCustomer,
                'orderTotal' => $orderTotal,
                'categoryTotal' => $categoryTotal,
            ]);
        }
        
        public function userUser()
        {
            $userUser = User::query()
                ->select("category_structures.category as schoolName", "users.*", "positions.name as positionName")
                ->join("positions", "positions.id", "=", "users.position")
                ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id");
            
            $userUser = $userUser->where('status', User::STATUS_USER)->get();
            return view('admin.users.user_user', [
                'users' => $userUser,
            ]);
        }
        
        public function userAdmin()
        {
            $userAdmin = User::query()
                ->select("category_structures.category as schoolName", "users.*", "positions.name as positionName")
                ->join("positions", "positions.id", "=", "users.position")
                ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id");
           
            $userAdmin = $userAdmin->where('status', User::STATUS_ADMIN)->get();
            
            return view('admin.users.user_admin', [
                'users' => $userAdmin,
            ]);
        }
        
        public function userDeleted()
        {
            $userDeleted = User::query()
                ->select("category_structures.category as schoolName", "users.*", "positions.name as positionName")
                ->join("positions", "positions.id", "=", "users.position")
                ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id");
            
            $userDeleted = $userDeleted->where('status', User::STATUS_DELETED)->get();
            
            return view('admin.users.user_deleted', [
                'users' => $userDeleted,
            ]);
        }
        
        public function createUser(Request $request)
        {
            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'categoryStructure' => 'required',
                'position' => 'required',
                'password' => 'required|min:6'
            ]);
            
            if (!is_null($request->file('add_image'))) {
                $avatar = $request->file('add_image');
                $avatarName = uniqid() . '.' . $avatar->getClientOriginalExtension();
                $avatar->move('assets/images/upload/', $avatarName);
            } else {
                $avatarName = 'default-user.jpg';
            }

//        dd($request->post('school'));
//        dd($request->post('position'));
            
            
            $user = User::create([
                'name' => $request->post('name'),
                'email' => $request->post('email'),
                'password' => bcrypt($request->post('password')),
                'status' => $request->post('status'),
                'categoryStructure_id' => $request->post('categoryStructure'),
                'position' => $request->post('position'),
                'img' => $avatarName,
            
            ]);

//        dd($user);
            
            return back();
        }
        
        public function userList(Request $request)
        {
            $filters = [
                User::STATUS_DELETED,
                User::STATUS_USER,
                User::STATUS_ADMIN,
            ];
            
            $users = User::query()
                ->select("category_structures.category as schoolName", "users.*", "positions.name as positionName")
                ->join("positions", "positions.id", "=", "users.position")
                ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id");
            
            if (in_array($request->get('filter'), $filters)) {
                $users->where('status', $request->get('filter'));
            }
            
            $categoriesStructure = DB::table("category_structures")->where('is_deleted', 'false')
                ->where('parent_category_id', null)
                ->get();
            $positions = Positions::all();
            
            $users = $users->get();
            
            $userIdDataForDelete = DB::table("users")->select("id")->where("categoryStructure_id", "!=", null)->get();
            $userIdForDelete = [];
            foreach ($userIdDataForDelete as $item) {
                $userIdForDelete[] = $item->id;
            }
            $userIdForDeleteArr = [];
            for ($x = 0; $x < count($userIdForDelete); $x++) {
                $isHaveFurniture = DB::table("furnitures")->where("user_id", "=", $userIdForDelete[$x])->first();
                if (empty($isHaveFurniture)) {
                    continue;
                } else {
                    $userIdForDeleteArr[] = $userIdForDelete[$x];
                }
            }
//        dd($users);
//        foreach ($users as $user){
//            if($user == ){
//
//            }
//        }
//            dd($users);
            $usersForSelect = User::query()
                ->select("category_structures.category as schoolName", "users.*", "positions.name as positionName")
                ->join("positions", "positions.id", "=", "users.position")
                ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id");
            $usersForSelect = $usersForSelect->get();
            
            return view('admin.users.user', [
                'usersForSelect' => $usersForSelect,
                'users' => $users,
                'categoriesStructure' => $categoriesStructure,
                'positions' => $positions,
                'userIdForDeleteArr' => $userIdForDeleteArr
            ]);
        }
        
        public function edit($id)
        {
            $user = User::query()
                ->select("category_structures.category as schoolName", "users.*", "positions.name as positionName")
                ->where('users.id', $id)
                ->join("positions", "positions.id", "=", "users.position")
                ->join("category_structures", "category_structures.id", "=", "users.categoryStructure_id")
                ->first();

//        $user = User::find($id);
            $id = DB::table('users')->select('categoryStructure_id')->where('id', $id)->value('categoryStructure_id');
            $categoriesStructureForUpdete = DB::table("category_structures")->where('is_deleted', 'false')->where('id', $id)->get();
            $categoriesStructure = DB::table("category_structures")->where('is_deleted', 'false')
                ->where('parent_category_id', null)
                ->get();
            $positions = Positions::all();
            
            return view('admin.users.edit', [
                'user' => $user,
                'categoriesStructureForUpdete' => $categoriesStructureForUpdete,
                'categoriesStructure' => $categoriesStructure,
                'positions' => $positions,
            ]);
        }
        
        public function update(Request $request)
        {
            $this->validate($request, [
                'name' => 'string',
                'email' => 'email',
            ]);
//        dd($request->input('password'));
            if ($request->input('password')) {
                $this->validate($request, [
                    'password' => 'min:6'
                ]);
            }
            $userId = $request->post('user_id');
            $user = User::find($userId);
            
            $user->name = $request->post('name');
            $user->email = $request->post('email');
            $user->status = $request->post('status');
            $user->position = $request->post('position');
            $user->categoryStructure_id = $request->post('categoriesStructure');
            
            if (!is_null($request->post('delete'))) {
                $user->img = null;
            } else {
                if (!is_null($request->file('img'))) {
                    $avatar = $request->file('img');
                    $avatarName = uniqid() . '.' . $avatar->getClientOriginalExtension();
                    $avatar->move('assets/images/upload/', $avatarName);
                    $user->img = $avatarName;
                }
            }
            if (!is_null($request->post('password'))) {
                $password = bcrypt($request->post('password'));
                $user->password = $password;
            }
            $user->save();
            
            return back();
        }
        
        public function delete($id)
        {
            $user = User::find($id);
            $user->status = User::STATUS_DELETED;
            $user->save();
            
            return back();
        }
        
        public function deleteFinally(Request $request, $id)
        {
            
            if ($request->get('selectUserDelete') === 0) {
                $this->validate($request, [
                    'selectUserDelete' => 'required'
                ]);
            }
            
            $selectedUser = $request->get('selectUserDelete');
            if ($selectedUser > 0) {
//                dd(1);
                DB::table('furnitures')->where('user_id', $id)->update(['user_id' => $selectedUser]);
                DB::table('orders')->where('user_id', $id)->update(['user_id' => $selectedUser]);
                $user = User::find($id);
                $user->delete();
            } else if ($selectedUser == null) {
                $user = User::find($id);
                $user->delete();
            }


//        dd($selectedUser);
            return back();
        }
        
        public function treat($id)
        {
            $user = User::find($id);
            $user->status = User::STATUS_USER;
            $user->save();
            
            return back();
        }
    }
