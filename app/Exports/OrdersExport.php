<?php

namespace App\Exports;

use App\Models\Orders;
use App\Models\Units;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use \stdClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromCollection, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $data = OrderDetails::all();
        foreach ($data as $order){
            $obj = new \stdClass();
            $obj->date = $order->created_at;
            $obj->id = $order->id;
            $obj->orders = $order->getOrder($order->details_id)
                ->join("products","products.id","=","orders.product_id")
                ->join("users","users.id","=","orders.user_id")
                ->join("units","units.id","=","products.unit")
                ->join("category","category.id","=","products.category")
                ->select("orders.*","products.id as productId","users.name as userName","products.name as productName","products.code","units.unit")
                ->where("category.story","=", 0)
                ->get();

            $arr[] = $obj;

        }
        $arr1 = [];
        foreach($arr as $order){

            $obj = new stdClass;
            $obj->created_at = $order->date . " # " . $order->id;
            $obj->productName = "";
            $obj->count = "";
            $obj->unit = "";
            $obj->code = "";
            $obj->status = "";

            array_push($arr1, $obj);

            foreach ($order->orders as $value) {
                $obj1 = new stdClass;
                $obj1->productName = $value->productName;
                $obj1->count = $value->count;
                $obj1->unit = $value->unit;
                $obj1->code = $value->code;
                if ($value->status == 'pending') {
                    $status = 'Ընթացքում է';
                }elseif($value->status == 'canceled_by_admin') {
                    $status = 'Մերժվել է ադմինի կողմից';
                }elseif($value->status == 'canceled_by_customer'){
                    $status = 'Մերժվել է հաճախորդի կողմից';
                }elseif($value->status == 'complete'){
                    $status = 'Ավարտված է';
                }elseif($value->status = 'archive'){
                    $status = 'Արխիվ';
                }else {
                    $status = 'Հաստատված է';
                }
                $obj1->status = $status;
                $obj1->created_at = $value->created_at;
                array_push($arr1, $obj1);
                    
            }

        }


        return collect($arr1);
    }
}
