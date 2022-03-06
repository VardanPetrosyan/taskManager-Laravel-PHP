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


class OrderExcelExportsManager implements FromView, ShouldAutoSize, WithEvents
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $orderDet = OrderDetails::all();
                $i = 1;
                foreach ($orderDet as $order) {
                    $count = $order->getOrder($order->details_id)
                        ->join("products","products.id","=","orders.product_id")
                        ->join("users","users.id","=","orders.user_id")
                        ->join("units","units.id","=","products.unit")
                        ->join("category","category.id","=","products.category")
                        ->join("category_structures","category_structures.id","=","orders.categoryStructure_id")
                        ->select("orders.*","products.id as productId","products.price as price","users.name as userName","users.id as userId","category_structures.category as schoolName","users.name as userName","products.name as productName","products.code","units.unit","category.name as categoryName")
                        ->where("category.story","=", 0)
                        ->where("orders.status","=", "approved")
                        ->get();

                    if(count($count)!=0){
                        if($i==1){
                            $row = 14;
                            $rows = 14+count($count)+1;
                        }else{
                            $row = $rows+12;
                            $rows = $row + count($count) +1;
                        }
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


                        $i++;
                    }

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

        foreach($arr as $order){
            foreach ($order->orders as $value) {
                if ($value->status == 'approved') {
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
                    $obj1->status = 'Հաստատված է';
                    $obj1->created_at = $value->created_at;
                    $arr1[$order->id][] = $obj1;
                }
            }
        }
        return view('excel.managerExcel', [
            'orders' => collect($arr1)
        ]);
    }
}