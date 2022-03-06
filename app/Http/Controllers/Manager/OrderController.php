<?php

namespace App\Http\Controllers\Manager;

use App\Models\Orders;
use App\Models\Product;
use App\Models\User;
use App\Models\Units;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;

class OrderController extends Controller
{
    public function index (Request $request)
    {
//    	$filters = [
//            Orders::STATUS_PENDING,
//            Orders::STATUS_ARCHIVE,
//            Orders::STATUS_COMPLETE,
//            Orders::STATUS_CANCELED_BY_ADMIN,
//            Orders::STATUS_CANCELED_BY_CUSTOMER,
//        ];
//
//        $orders = Orders::query()
//            ->join('users','users.id', '=', 'orders.user_id')
//            ->join('products','products.id', '=', 'orders.product_id')
//            ->join('units','units.id', '=', 'products.unit')
//            ->select("orders.*", "users.name as userName","products.name as productName", "units.unit as unitName");
//
//        if (in_array($request->get('filter'), $filters)) {
//            $orders->where('orders.status', $request->get('filter'));
//        }
//
//        $units = Units::all();
//
//        $orders = $orders->get();
//
//        $users = User::all(["id","name","email"]);
//
//        $products = Product::query()
//            ->join("units","units.id", "=", "products.unit")
//            ->select("products.id", "products.name", "units.unit as unitName")
//            ->get();
//
//            $arr = [];
//
//            $orderDetails = OrderDetails::query()
//                ->where("orderType", "=", 1)
//            	->join("orders","orders.details_id", "order_details.id")
//            	->join("users","users.id", "=", "orders.user_id")
//            	->select("order_details.created_at", "order_details.id", "order_details.status", "users.name as userName")
//            	->groupBy("order_details.id","order_details.status","order_details.created_at", "users.name")
//            	->get();
//
//            foreach ($orderDetails as $order){
//                $obj = new \stdClass();
//                $obj->date = $order->created_at;
//                $obj->orders = $order->approvedOrders($order->details_id)
//                    ->join("products","products.id","=","orders.product_id")
//                    ->join("users","users.id","=","orders.user_id")
//                    ->join("units","units.id","=","products.unit")
//                    ->select("orders.*","products.id as productId","users.name as userName","products.name as productName","products.code","units.unit")
//                    ->get();
//
//                $arr[] = $obj;
//            }
////            dd($arr);
////            $newArr = [];
////
////
////            foreach ($arr as $newOrders){
////
////                foreach ($orders as $order) {
////
////                }
////
////            }
//
////            dd($arr);
//
//
//        return view('manager.orders.order')->with([
//            'orders'   => $orders,
//            'users'    => $users,
//            'products' => $products,
//            'units' => $units,
//            'objects' => $arr,
//            'orderDetails' => $orderDetails,
//        ]);


        $filters = [
            Orders::STATUS_PENDING,
            Orders::STATUS_ARCHIVE,
            Orders::STATUS_COMPLETE,
            Orders::STATUS_CANCELED_BY_ADMIN,
            Orders::STATUS_CANCELED_BY_CUSTOMER,
        ];

        $orders = Orders::query()
            ->join('users','users.id', '=', 'orders.user_id')
            ->join('products','products.id', '=', 'orders.product_id')
            ->join('units','units.id', '=', 'products.unit')

            ->select("orders.*", "users.name as userName","products.name as productName", "units.unit as unitName");

        if (in_array($request->get('filter'), $filters)) {
            $orders->where('orders.status', $request->get('filter'));
        }

        $units = Units::all();
        $orders = $orders->get();
        $users = User::all(["id","name","email"]);
        $products = Product::query()
            ->join("units","units.id", "=", "products.unit")
            ->select("products.id", "products.name", "units.unit as unitName")
            ->get();

        $arr = [];
        // $orderDetails = OrderDetails::all();
        $orderDetails = OrderDetails::query()
            ->join("orders","orders.details_id", "order_details.id")
            ->join("users","users.id", "=", "orders.user_id")
            ->select("order_details.created_at", "order_details.id", "order_details.status", "users.name as userName")
            ->where('orderType','1')
            ->groupBy("order_details.id","order_details.status","order_details.created_at", "users.name")
            ->get();
        foreach ($orderDetails as $order){
            $obj = new \stdClass();
            $obj->date = $order->created_at;
            $obj->orders = $order->getOrder($order->details_id)
                ->join("products","products.id","=","orders.product_id")
                ->join("users","users.id","=","orders.user_id")
                ->join("units","units.id","=","products.unit")
                ->select("orders.*","products.id as productId","users.name as userName","products.name as productName","products.code","units.unit")
                ->get();

            $arr[] = $obj;
        }

        return view('manager.orders.order')->with([
            'orders'   => $orders,
            'users'    => $users,
            'products' => $products,
            'units' => $units,
            'objects' => $arr,
            'orderDetails' => $orderDetails,
        ]);

    }

    public function detail ($id) 
    {
    	$orderDetails = OrderDetails::find($id);
        $arr = [];
        $obj = new \stdClass();
        $obj->orderDetails = $orderDetails->getOrder($orderDetails->details_id)
            ->join("products","products.id","=","orders.product_id")
            ->join("users","users.id","=","orders.user_id")
            ->join("units","units.id","=","products.unit")
            ->join("category_structures","category_structures.id","=","orders.categoryStructure_id")
            ->select("orders.*","products.id as productId","users.name as userName","products.name as productName","products.code","units.unit","category_structures.category as categoryStructureName")
            ->get();

        foreach ($obj as $object) {

        	foreach ($object as $k => $name) {
                if($name->status !== 'approved'){
                    unset($object[$k]);
//                    dd($object);
                };
        		$arr[] = $name->userName;

        	}
        }

        $userName = $arr[0];
    
        return view('manager.orders.order_details', [
        	'object' => $obj,
        	'userName' => $userName,
        ]);
    }

    public function approve (Request $request, $id)
    {
		$order = Orders::find($id);
    	$order->status = $request->get('status_approve');
    	$order->approved = intval($request->get('count_approve'));
    	$order->save();

        $products = Product::find($order->product_id);
        $products->count = $products->count + $order->count - $order->approved;
        $products->save();

        return back();
    }

    public function pending()
    {
        $orders = DB::table("orders")
            ->join('users','users.id', '=', 'orders.user_id')
            ->join('products','products.id', '=', 'orders.product_id')
            ->select("orders.*", "users.name as userName","products.name as productName")
            ->where('orders.status', '=', Orders::STATUS_PENDING)
            ->get();
        $users = User::all(["id","name","email"]);
        $products = Product::all(["id","name"]);

        return view('manager.orders.pending', [
            'orders' => $orders,
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function complete()
    {
        $orders = DB::table("orders")
            ->join('users','users.id', '=', 'orders.user_id')
            ->join('products','products.id', '=', 'orders.product_id')
            ->select("orders.*", "users.name as userName","products.name as productName")
            ->where('orders.status', '=', Orders::STATUS_COMPLETE)
            ->get();
        $users = User::all(["id","name","email"]);
        $products = Product::all(["id","name"]);

        return view('manager.orders.complete', [
            'orders' => $orders,
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function canceledAdmin()
    {
        $orders = DB::table("orders")
            ->join('users','users.id', '=', 'orders.user_id')
            ->join('products','products.id', '=', 'orders.product_id')
            ->select("orders.*", "users.name as userName","products.name as productName")
            ->where('orders.status', '=', Orders::STATUS_CANCELED_BY_ADMIN)
            ->get();

        $users = User::all(["id","name","email"]);
        $products = Product::all(["id","name"]);

        return view('manager.orders.canceled_by_admin', [
            'orders' => $orders,
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function canceledCustomer()
    {
        $orders = DB::table("orders")
            ->join('users','users.id', '=', 'orders.user_id')
            ->join('products','products.id', '=', 'orders.product_id')
            ->select("orders.*", "users.name as userName","products.name as productName")
            ->where('orders.status', '=', Orders::STATUS_CANCELED_BY_CUSTOMER)
            ->get();
        $users = User::all(["id","name","email"]);
        $products = Product::all(["id","name"]);

        return view('manager.orders.canceled_by_customer', [
            'orders' => $orders,
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function archive()
    {
        $orders = DB::table("orders")
            ->join('users','users.id', '=', 'orders.user_id')
            ->join('products','products.id', '=', 'orders.product_id')
            ->select("orders.*", "users.name as userName","products.name as productName")
            ->where('orders.status', '=', Orders::STATUS_ARCHIVE)
            ->get();
        $users = User::all(["id","name","email"]);
        $products = Product::all(["id","name"]);

        return view('manager.orders.archive', [
            'orders' => $orders,
            'users' => $users,
            'products' => $products,
        ]);
    }

    public function filter (Request $request) {
        $date = explode("-", $request->date);

        $firstDate = date("Y-m-d", strtotime($date[0]));
        $secondDate = date("Y-m-d", strtotime($date[1]));

        $orderDetails = OrderDetails::query()
            ->join("orders","orders.details_id", "order_details.id")
            ->join("users","users.id", "=", "orders.user_id");

        if(isset($request->user)){
            $orderDetails = $orderDetails->whereIn("orders.user_id", $request->user);
        }
        if(isset($request->date) && strtotime($firstDate) != strtotime($secondDate)){
            $orderDetails = $orderDetails
                ->where("orders.created_at", ">", $firstDate."00:00:00")
                ->where("orders.created_at", "<", $secondDate."00:00:00");
        }

        $orderDetails = $orderDetails->select("order_details.created_at", "order_details.id", "users.name as userName")
            ->where('orderType',1)
        ->groupBy("order_details.id","order_details.created_at", "users.name")
        ->get();

        echo json_encode($orderDetails);

        
        // return response()->json(['msg' => 'has been successfully']);
        // return redirect()->route('admin_order_all')->withInput(['filterData' => $orderDetails]);

    }

    public function ordinary (Request $request) 
    {
        if($request->type[0] == 'orders') {
            $orderDetails = OrderDetails::query()
                ->join("orders","orders.details_id", "order_details.id")
                ->join("users","users.id", "=", "orders.user_id")
                ->where('orderType', 0)
                ->select("order_details.created_at", "order_details.id", "order_details.status", "users.name as userName")
                ->groupBy("order_details.id","order_details.status","order_details.created_at", "users.name")
                ->get();
        } elseif($request->type[0] == 'claim-orders') {
            $orderDetails = OrderDetails::query()
                ->join("orders","orders.details_id", "order_details.id")
                ->join("users","users.id", "=", "orders.user_id")
                ->where('orderType', 1)
                ->select("order_details.created_at", "order_details.id", "order_details.status", "users.name as userName")
                ->groupBy("order_details.id","order_details.status","order_details.created_at", "users.name")
                ->get();
        }

        echo json_encode($orderDetails);
    }
    
}
