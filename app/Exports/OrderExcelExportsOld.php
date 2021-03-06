<?php
/**
 * Created by PhpStorm.
 * User: Norayr
 * Date: 1/9/2019
 * Time: 2:31 PM
 */

namespace App\Exports;
use App\Models\Orders;

use App\Models\Units;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \stdClass;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class OrderExcelExports implements FromView, ShouldAutoSize, WithEvents
{

    public function registerEvents(): array
    {


        return [
          AfterSheet::class => function(AfterSheet $event){

            for($i = 1;$i<=count(Orders::all());$i++ ) {
                $row = $i*14;
                $rows = $i*14+2;
                $event->sheet->getStyle("A$row:L$rows")->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                        'horizontal' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                        'vertical' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '00000000'],
                        ],
                    ],
                ]);

                }
          }
        ];
    }

    public function view(): View
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
                ->join("category_structures","category_structures.id","=","orders.categoryStructure_id")
                ->select("orders.*","products.id as productId","products.price as price","users.name as userName","users.id as userId","category_structures.category as schoolName","users.name as userName","products.name as productName","products.code","units.unit","category.name as categoryName")
                ->where("category.story","=", 0)
                ->get();

            $arr[] = $obj;

        }
        $arr1 = [];
//        dd($arr);
        foreach($arr as $order){
            $obj = new stdClass;
            $obj->created_at = $order->date . " # " . $order->id;
            $obj->productName = "";
            $obj->categoryName = "";
            $obj->count = "";
            $obj->unit = "";
            $obj->code = "";
            $obj->schoolName = "";
            $obj->status = "";
            $obj->userName = "";
            $obj->userId = "";
            $obj->price = "";

            array_push($arr1, $obj);

            foreach ($order->orders as $value) {
                $obj1 = new stdClass;
                $obj1->productName = $value->productName;
                $obj1->count = $value->count;
                $obj1->unit = $value->unit;
                $obj1->code = $value->code;
                $obj1->categoryName = $value->categoryName;
                $obj1->schoolName = $value->schoolName;
                $obj1->userName = $value->userName;
                $obj1->userId = $value->userId;
                $obj1->price = $value->price;


                if ($value->status == 'pending') {
                    $status = '?????????????????? ??';
                }elseif($value->status == 'canceled_by_admin') {
                    $status = '?????????????? ?? ???????????? ????????????';
                }elseif($value->status == 'canceled_by_customer'){
                    $status = '?????????????? ?? ?????????????????? ????????????';
                }elseif($value->status == 'complete'){
                    $status = '???????????????? ??';
                }elseif($value->status = 'archive'){
                    $status = '??????????';
                }else {
                    $status = '?????????????????? ??';
                }
                $obj1->status = $status;
                $obj1->created_at = $value->created_at;
                array_push($arr1, $obj1);

            }

        }
        return view('excel.adminExcel', [
            'orders' => collect($arr1)
        ]);


    }






}