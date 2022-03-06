<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Models\Orders;
    use App\Models\Product;
    use App\Models\User;
    use App\Models\Units;
    use App\Models\OrderDetails;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\DB;
    
    use App\Mail\mailToUserInApprove;
    use App\Mail\mailToManagerInApprove;
    use Illuminate\Support\Facades\Mail;
    
    class OrdersController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(Request $request)
        {
            
            $filters = [
                Orders::STATUS_PENDING,
                Orders::STATUS_ARCHIVE,
                Orders::STATUS_COMPLETE,
                Orders::STATUS_CANCELED_BY_ADMIN,
                Orders::STATUS_CANCELED_BY_CUSTOMER,
            ];
            
            $orders = Orders::query()
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->join('units', 'units.id', '=', 'products.unit')
                ->select("orders.*", "users.name as userName", "products.name as productName", "units.unit as unitName");
            
            if (in_array($request->get('filter'), $filters)) {
                $orders->where('orders.status', $request->get('filter'));
            }
            
            $units = Units::all();
            $orders = $orders->get();
            $users = User::all(["id", "name", "email"]);
            $products = Product::query()
                ->join("units", "units.id", "=", "products.unit")
                ->select("products.id", "products.name", "units.unit as unitName")
                ->get();
            
            $arr = [];
            // $orderDetails = OrderDetails::all();
            $orderDetails = OrderDetails::query()
                ->join("orders", "orders.details_id", "order_details.id")
                ->join("users", "users.id", "=", "orders.user_id")
                ->select("order_details.created_at", "order_details.isseen", "order_details.date_while", "order_details.id", "order_details.status", "users.name as userName")
                ->groupBy("order_details.id", "order_details.status", "order_details.created_at", "users.name")
                ->where('orderType',0)
//                ->orderBy("id","desc")
                ->get();
            foreach ($orderDetails as $order) {
                $obj = new \stdClass();
                $obj->date = $order->created_at;
                $obj->orders = $order->getOrder($order->details_id)
                    ->join("products", "products.id", "=", "orders.product_id")
                    ->join("users", "users.id", "=", "orders.user_id")
                    ->join("units", "units.id", "=", "products.unit")
                    ->select("orders.*", "products.id as productId", "users.name as userName", "products.name as productName", "products.code", "units.unit")
                    ->get();
                
                $arr[] = $obj;
                
            }
//        $orderDetailsArr = [];
//        foreach ($orderDetails as $order){
//            $orderDetailsArr[] = $order;
//        }
//        dd($orderDetailsArr);
            return view('admin.orders.order')->with([
                'orders' => $orders,
                'users' => $users,
                'products' => $products,
                'units' => $units,
                'objects' => $arr,
                'orderDetails' => $orderDetails,
            ]);
        }
        
        public function detail($id)
        {
            $orderDetails = OrderDetails::find($id);
            $orderDetails->isseen = 1;
            $orderDetails->save();
            $orderDetails->refresh();
          
            $arr = [];
            $obj = new \stdClass();
            $obj->orderDetails = $orderDetails->getOrder($orderDetails->details_id)
                ->join("products", "products.id", "=", "orders.product_id")
                ->join("users", "users.id", "=", "orders.user_id")
                ->join("units", "units.id", "=", "products.unit")
                ->join("category_structures", "category_structures.id", "=", "orders.categoryStructure_id")
                ->select("orders.*", "products.id as productId", "users.name as userName", "products.name as productName", "products.code", "units.unit", "category_structures.category as schoolName")
                ->get();
//            dd($obj->orderDetails);
            foreach ($obj as $object) {
                foreach ($object as $name) {
                    $arr[] = $name->userName;
                }
            }
            
            $userName = $arr[0];
            
            return view('admin.orders.order_claim', [
                'object' => $obj,
                'userName' => $userName,
            ]);
        }
        
        public function approve(Request $request, $id)
        {
            $order = Orders::find($id);
//    	dd($order->user_id);
            $order->status = $request->get('status_approve');
            if ($request->get('status_approve') == 'approved') {
                $order->approved = intval($request->get('count_approve'));
            } else {
                $order->approved = null;
            };
            $order->save();
            
            $products = Product::find($order->product_id);
            $products->count = $products->count + $order->count - $order->approved;
            $products->save();
            
            $user = User::find($order->user_id);
        Mail::to($user->email)->send(new mailToUserInApprove());
        $managers = User::where('status','manager')->get();
        foreach ($managers as $manager){
            Mail::to($manager->email)->send(new mailToManagerInApprove($user));
        }
            
            
            return back();
        }
        
        public function approveOrders(Request $request)
        {
//        dd(count($request->all())/2);
            for ($i = 0; $i < count($request->all()) / 2; $i++) {
                
                $order = Orders::find($request->input('orderId_' . $i));
                $order->status = 'approved';
                $order->approved = $request->input('count_' . $i);
                $order->save();
                
                $products = Product::find($order->product_id);
                $products->count = $products->count + $order->count - $order->approved;
                $products->save();
                
            }
            
            $user = User::find($order->user_id);
        Mail::to($user->email)->send(new mailToUserInApprove());
        $managers = User::where('status','manager')->get();
        foreach ($managers as $manager){
            Mail::to($manager->email)->send(new mailToManagerInApprove($user));
        }
            
            return json_encode('success');
            
            
        }
        
        public function edit($id)
        {
            $order = Orders::query()
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->join('units', 'units.id', '=', 'products.unit')
                ->select("orders.*", "units.unit as unitName")
                ->where("orders.id", $id)
                ->first();
            
            return view('admin.orders.order_status_edit', [
                'order' => $order,
            ]);
        }
        
        public function update(Request $request)
        {
            $id = $request->post('order_id');
            $order = Orders::find($id);
            $order->status = $request->post('status');
            $order->count = $request->post('count');
            $order->save();
            
            if (!$request->ajax()) {
                return redirect()->route('admin_order_all');
            }
        }
        
        public function showArchive()
        {
            $orders = DB::table("orders")
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select("orders.*", "users.name as userName", "products.name as productName")
                ->where('orders.status', '=', Orders::STATUS_ARCHIVE)
                ->get();
            
            return view('admin.orders.order_archive')->with(['ord' => $orders]);
        }
        
        public function backUpArchive(Request $request, $id)
        {
            $order = Orders::find($id);
            $status = $request->get('status_change_from_archive');
            $order->status = $status;
            $order->save();
            
            return back();
        }
        
        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $this->validate($request, [
                'status' => 'required',
                'count' => 'required'
            ]);
            
            $orders = Orders::create([
                'status' => $request->post('status'),
                'user_id' => $request->post('user_id'),
                'product_id' => $request->post('product_id'),
                'count' => $request->post('count'),
                'created_at' => date('Y-m-d H:i:s', time()),
            ]);
            
            return redirect()->route('admin_order_all');
        }
        
        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function delete($id)
        {
            $order = Orders::find($id);
            $order->status = Orders::STATUS_ARCHIVE;
            $order->save();
            
            return redirect()->route('admin_order_all');
        }
        
        public function edittable(Request $request)
        {
            switch ($request->action) {
                case 'edit':
                    $request->validate([
                        'title' => 'required|max:12',
                    ]);
                    $editcat = Category::find($request->id);
                    $editcat->name = $request->title;
                    $editcat->parent = $request->parent;
                    $editcat->status = $request->status;
                    
                    $editcat->save();
                    $response = ['action' => $request->action, 'id' => $request->id];
                    return json_encode($response);
                    break;
                case 'delete':
                    $category = Category::find($request->id);
                    $category->status = 'passive';
                    $category->save();
                    
                    $response = ['action' => $request->action, 'id' => $request->id];
                    echo json_encode($response);
                    die;
                    break;
            }
            
        }
        
        public function pending()
        {
            $orders = DB::table("orders")
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select("orders.*", "users.name as userName", "products.name as productName")
                ->where('orders.status', '=', Orders::STATUS_PENDING)
                ->get();
            $users = User::all(["id", "name", "email"]);
            $products = Product::all(["id", "name"]);
            
            return view('admin.orders.pending', [
                'orders' => $orders,
                'users' => $users,
                'products' => $products,
            ]);
        }
        
        public function complete()
        {
            $orders = DB::table("orders")
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select("orders.*", "users.name as userName", "products.name as productName")
                ->where('orders.status', '=', Orders::STATUS_COMPLETE)
                ->get();
            $users = User::all(["id", "name", "email"]);
            $products = Product::all(["id", "name"]);
            
            return view('admin.orders.complete', [
                'orders' => $orders,
                'users' => $users,
                'products' => $products,
            ]);
        }
        
        public function canceledAdmin()
        {
            $orders = DB::table("orders")
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select("orders.*", "users.name as userName", "products.name as productName")
                ->where('orders.status', '=', Orders::STATUS_CANCELED_BY_ADMIN)
                ->get();
            
            $users = User::all(["id", "name", "email"]);
            $products = Product::all(["id", "name"]);
            
            return view('admin.orders.canceled_by_admin', [
                'orders' => $orders,
                'users' => $users,
                'products' => $products,
            ]);
        }
        
        public function canceledCustomer()
        {
            $orders = DB::table("orders")
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select("orders.*", "users.name as userName", "products.name as productName")
                ->where('orders.status', '=', Orders::STATUS_CANCELED_BY_CUSTOMER)
                ->get();
            $users = User::all(["id", "name", "email"]);
            $products = Product::all(["id", "name"]);
        
            return view('admin.orders.canceled_by_customer', [
                'orders' => $orders,
                'users' => $users,
                'products' => $products,
            ]);
        }
        
        public function archive()
        {
            $orders = DB::table("orders")
                ->join('users', 'users.id', '=', 'orders.user_id')
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->select("orders.*", "users.name as userName", "products.name as productName")
                ->where('orders.status', '=', Orders::STATUS_ARCHIVE)
                ->get();
            $users = User::all(["id", "name", "email"]);
            $products = Product::all(["id", "name"]);
            
            return view('admin.orders.archive', [
                'orders' => $orders,
                'users' => $users,
                'products' => $products,
            ]);
        }
        
        public function filter(Request $request)
        {
            $date = explode("-", $request->date);
            
            $firstDate = date("Y-m-d", strtotime($date[0]));
            $secondDate = date("Y-m-d", strtotime($date[1]));
            
            $orderDetails = OrderDetails::query()
                ->join("orders", "orders.details_id", "order_details.id")
                ->join("users", "users.id", "=", "orders.user_id");
            
            if (isset($request->user)) {
                $orderDetails = $orderDetails->whereIn("orders.user_id", $request->user);
            }
            if (isset($request->date) && strtotime($firstDate) != strtotime($secondDate)) {
                
                $orderDetails = $orderDetails
                    ->where("orders.created_at", ">", $firstDate . " 00:00:00")
                    ->where("orders.created_at", "<", $secondDate . " 00:00:00");
               
            }
            if (isset($request->type)) {
                if ($request->type[0] == 'orders') {
                    $orderDetails = $orderDetails
                        ->where('orderType', 0);
                } elseif ($request->type[0] == 'claim-orders') {
                    $orderDetails = $orderDetails
                        ->where('orderType', 1);
                }
            }
//            dd($orderDetails);
            $orderDetails = $orderDetails->select("order_details.created_at", "order_details.isseen", "order_details.date_while", "order_details.id", "users.name as userName")
                ->groupBy("order_details.id", "order_details.created_at", "users.name")
                ->get();
            
            echo json_encode($orderDetails);
        }
        
        public function ordinary(Request $request)
        {
//            dd($request->type[0]);
            if (is_null($request->user)) {
            
            
//        return json_encode($orwheres);die;
                if ($request->type[0] == 'orders') {
                    $orderDetails = OrderDetails::query()
                        ->join("orders", "orders.details_id", "order_details.id")
                        ->join("users", "users.id", "=", "orders.user_id")
                        ->where('orderType', 0)
                        ->select("order_details.created_at", "order_details.date_while", "order_details.id", "order_details.status", "users.name as userName")
                        ->groupBy("order_details.id", "order_details.status", "order_details.created_at", "users.name")
                        ->get();
                    
                    
                } elseif ($request->type[0] == 'claim-orders') {
                    $orderDetails = OrderDetails::query()
                        ->join("orders", "orders.details_id", "order_details.id")
                        ->join("users", "users.id", "=", "orders.user_id")
                        ->where('orderType', 1)
                        ->select("order_details.created_at", "order_details.date_while", "order_details.id", "order_details.status", "users.name as userName")
                        ->groupBy("order_details.id", "order_details.status", "order_details.created_at", "users.name")
                        ->get();
                }
                
            } else {
                $orwheres = [];
                foreach ($request->user as $k => $v) {
                    $orwheres[] = $v;
                }


//        return json_encode($orwheres);die;
                if ($request->type[0] == 'orders') {
                    $orderDetails = OrderDetails::query()
                        ->join("orders", "orders.details_id", "order_details.id")
                        ->join("users", "users.id", "=", "orders.user_id")
                        ->where('orderType', 0)
                        ->whereIn('users.id', $orwheres)
                        ->select("order_details.created_at", "order_details.date_while", "order_details.id", "order_details.status", "users.name as userName")
                        ->groupBy("order_details.id", "order_details.status", "order_details.created_at", "users.name")
                        ->get();
                    
                    
                } elseif ($request->type[0] == 'claim-orders') {
                    $orderDetails = OrderDetails::query()
                        ->join("orders", "orders.details_id", "order_details.id")
                        ->join("users", "users.id", "=", "orders.user_id")
                        ->where('orderType', 1)
                        ->whereIn('users.id', $orwheres)
                        ->select("order_details.created_at", "order_details.date_while", "order_details.id", "order_details.status", "users.name as userName")
                        ->groupBy("order_details.id", "order_details.status", "order_details.created_at", "users.name")
                        ->get();
                }
                
            }
            
            echo json_encode($orderDetails);
        }
    }
