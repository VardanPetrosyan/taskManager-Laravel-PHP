<?php

namespace App\Http\Controllers;


use App\Models\Orders;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Models\User as Myuser;
use App\Order;
use App\User as Orderer;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\File;
use App\Mail\mailToAdminInOrder;
use App\Mail\mailToUserInOrder;
use Illuminate\Support\Facades\Mail;


class orderController extends Controller
{
    public function index(Request $request){

        DB::transaction(function() use ($request)
        {

            $user = Myuser::find($request["user"]);

            $orderDetails = new OrderDetails();
            $orderDetails->save();

            foreach ($request->products as $product){

                $count = DB::table("products")->where(["id"=>$product["product"]["id"]])->first(["count"])->count;
                $getCount = 0;

                if($count >= $product["count"]){
                    $getCount = $product["count"];
                }else{
                    $getCount = $count;
                }

                $order = new Order();
                $order->categoryStructure_id = $user->categoryStructure_id;
                $order->user_id = $request["user"];
                $order->product_id = $product["product"]["id"];
                $order->count = $getCount;
                $order->reason = $request["purpose"];
                $order->exploiter = $request['exploiterValue'];
                $order->edu_obj = $request['otherSchoolValue'];
                $order->status = "pending";
                $order->storage = $product["product"]["story"];
                $order->details_id = $orderDetails->id;
                $order->save();

                Product::where(["id" => $product["product"]["id"]])->update(["count" => $count-$getCount]);
            }

            $users = Orderer::find($request["user"]);

            $admins = Orderer::where('status','admin')->get();

            Mail::to($users->email)->send(new mailToUserInOrder());
            foreach ($admins as $admin){
                Mail::to($admin->email)->send(new mailToAdminInOrder($users));
            }
        });
        return response()->json(1);
    }


    public function myOrders(Request $request){


//        dd($request->all());
        $arr = [];
            $data = OrderDetails::query();
            $data = $data->where(["orderType" => $request["orderType"]?1:0]);
//            $data = $data->leftJoin("school","school.id","=","order_details.school_id");
//            $data = $data->select("order_details.*","school.name as schoolName");

//            dd($data);


            if(!empty($request->date) && strtotime($request->date[0]) != strtotime($request->date[1])){
                $data = $data
                    ->where("order_details.created_at", ">", $request['date'][0]." 00:00:00")
                    ->where("order_details.created_at", "<", $request['date'][1]." 00:00:00");
            }

            $data = $data
//                ->rightJoin("orders","order_details.id","=","orders.details_id")
//                ->where(["orders.user_id" => $request['user_id']])
//                ->select("order_details.*")
                ->get();


//            dd($data);

            foreach ($data as $order){
                $obj = new \stdClass();
                $obj->date = $order->created_at;
                $obj->id = $order->id;
                $obj->orders = $order->getOrder()
                    ->join("products","products.id", "=", "orders.product_id")
                    ->join("units","units.id", "=", "products.unit")
                    ->leftJoin("category_structures","category_structures.id","=","orders.categoryStructure_id")
                    ->whereIn("orders.status",!empty($request->status)?$request->status:['pending','approved','canceled_by_customer','canceled_by_admin','complete'])
//                    ->join("category","category.id","=","products.category")
                    ->where("orders.user_id",$request['user_id'])
                    ->select(
                        "category_structures.category as schoolName",
                        "orders.*",
                        "products.id as productId",
                        "products.name as productName",
                        "products.image as productImg",
                        "products.code","units.unit"
                    )
                    ->get();
//                dd($obj);
                if(count($obj->orders)){
                    array_push($arr, $obj);
                }
            }
            return response()->json($arr);
    }

    public function reserve(Request $request){
        $months = [
            'Jan'=>'01',
            'Feb'=>'02',
            'Mar'=>'03',
            'Apr'=>'04',
            'May'=>'05',
            'Jun'=>'06',
            'Jul'=>'07',
            'Aug'=>'08',
            'Sep'=>'09',
            'Oct'=>'10',
            'Nov'=>'11',
            'Dec'=>'12',
        ];
        if(isset($request->type)){
            $dateTo=null;
//            dd($request->data);
            if(!empty($request->date)){
                $dateTo = $request->date;
                $dateTo = explode(' ',$dateTo);
                $dateTo[1] = $months[$dateTo[1]];
                $dateTo = array_reverse($dateTo);
                $dateTo = implode('-',$dateTo);
            }

            $order_details = new OrderDetails();
            $order_details->orderType = $request->orderType;
            $order_details->date_while = $dateTo;
            $order_details->save();
//            $last = OrderDetails::orderBy('id','desk')->first();
            $userId = '';
            foreach ($request->data as $item){
                $userId = $item['user'];


                $product = new Product();
                $product->name = $item['name'];
                $product->unit = $item['unit'];
                $product->category = 1;
                $product->status = "reserve";
                $product->save();

                $product_id = $product->id;



                $order = new Orders();
                $order->categoryStructure_id = $item['school'];
                $order->user_id = $item['user'];
                $order->product_id = $product_id;
                $order->details_id = $order_details->id;
                $order->urgent = $item['urgent'];
                $order->reason = $item['reason'];
                $order->count = $item['count'];
                $order->save();

            }
        }
        $user = Orderer::find($userId);
        $admins = Orderer::where('status','admin')->get();
        Mail::to($user->email)->send(new mailToUserInOrder());
        foreach ($admins as $admin){
            Mail::to($admin->email)->send(new mailToAdminInOrder($user));
        }


//        else{
//
//            foreach ($request->data as $file){
//                $fileName = time().'.'.$file->getClientOriginalExtension();
//                $dirName = base_path() . '/public/assets/images/upload/';
//                $file->move($dirName, $fileName);
//
//                $product = new Product();
//                $product->name = $fileName;
//                $product->unit = 5;
//                $product->status = "reserve";
//                $product->save();
//
//                $product_id = $product->id;
//
//
//                $order_details = new OrderDetails();
//                $order_details->orderType = $request->orderType;
//                $order_details->save();
//
//                $order = new Orders();
//                $order->user_id = $request['user'];
//                $order->status = "pending";
//                $order->product_id = $product_id;
//                $order->details_id = $order_details->id;
//                $order->count = 1;
//                $order->save();
//            }
//
//        }

        return response()->json(true);

    }

    public function cancelOrder(Request $request){
        $updateCount = Orders::find($request["order_id"]);
        $updateCount->status = "canceled_by_customer";
        $updateCount->save();

        $products = Product::find($updateCount->product_id);
        $products->count = $products->count + $request["order_count"];
        $products->save();

        return $this->myOrders($request);
    }

    public function toArchive(Request $request){
        $updateCount = Orders::find($request["order_id"]);
        $updateCount->status = "archive";
        $updateCount->save();

//        $products = Product::find($updateCount->product_id);
//        $products->count = $products->count + $request["order_count"];
//        $products->save();

        return $this->myOrders($request);
    }


    public function reorder(Request $request){
        $updateCount = Orders::find($request["order_id"]);
        $updateCount->status = "pending";
        $updateCount->approved = null;
        $updateCount->save();
        $updateDetalis = OrderDetails::find($request["detailsId"]);
        $updateDetalis->isseen = 0;
        $updateDetalis->save();
        $products = Product::find($updateCount->product_id);
        $products->count = $products->count - $request["order_count"];
        $products->save();
        return $this->myOrders($request);
    }
}
