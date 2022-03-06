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
        public $userId;
        public $orderTab;
        public $orderDate;
        public $orderDateStart;
        public $orderDateEnd;
        
        public function __construct($userId = null, $orderTab = null, $orderDate = null)
        {
            $this->orderTab = $orderTab;
            $this->userId = $userId;
            $this->orderDate = $orderDate;
//        dd($userId);
            
            if ($orderDate != null) {
                $this->orderDateEnd = explode(' - ', $orderDate)[1];
                $this->orderDateStart = explode(' - ', $orderDate)[0];
                $this->orderDateStart = date("Y-m-d", strtotime($this->orderDateStart)) . ' 00:00:00';
                $this->orderDateEnd = date("Y-m-d", strtotime($this->orderDateEnd)) . ' 00:00:00';
            }
            $this->orderDate = $orderDate;
            
        }
        
        public function registerEvents(): array
        {
        if($this->orderDateStart == $this->orderDateEnd){
            $this->orderDate =null;
            $this->orderDateStart = null;
            $this->orderDateEnd = null;
        }
//        dd($this->orderTab,$this->userId,$this->orderDate,$this->orderDateStart,$this->orderDateEnd);
            if ($this->userId === null) {
                return [
                    AfterSheet::class => function (AfterSheet $event) {
                        
                        if ($this->orderTab === null || $this->orderTab === 0) {
                            if ($this->orderDate === null ) {
                                $orderDet = OrderDetails::where('orderType',0)->get();
//                        dd($orderDet );
                            } else {
                                $orderDet = OrderDetails::where('orderType',0)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                            }
                        } else {
                            if ($this->orderDate === null) {
                                $orderDet = OrderDetails::where('orderType', $this->orderTab)->get();
                                
                            } else {
                                $orderDet = OrderDetails::where('orderType', $this->orderTab)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                            }
                        }
                        
                        $i = 1;
                        foreach ($orderDet as $order) {
                            
                            $count = $order->getOrder($order->details_id)
                                ->join("products", "products.id", "=", "orders.product_id")
                                ->join("users", "users.id", "=", "orders.user_id")
                                ->join("units", "units.id", "=", "products.unit")
                                ->join("category", "category.id", "=", "products.category")
                                ->join("category_structures", "category_structures.id", "=", "orders.categoryStructure_id")
                                ->select("orders.*", "products.id as productId", "products.price as price", "users.name as userName", "users.id as userId", "category_structures.category as schoolName", "users.name as userName", "products.name as productName", "products.code", "units.unit", "category.name as categoryName")
                                ->where("category.story", "=", 0)
                                ->where("orders.status", "=", "approved")
                                ->get();
                           
                            if (count($count) != 0) {
                                if ($i == 1) {
                                    $row = 14;
                                    $rows = 14 + count($count) + 1;
                                } else {
                                    $row = $rows + 12;
                                    $rows = $row + count($count) + 1;
                                }
                                
                                
                                $event->sheet->getStyle("A$row:K$rows")->applyFromArray([
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
            } else {
                return [
                    AfterSheet::class => function (AfterSheet $event) {
//                $orderDet = OrderDetails::all();
//                if($this->orderTab === null){
//                    $orderDet = OrderDetails::all();
//                }else{
//                    $orderDet = OrderDetails::where('orderType',$this->orderTab)->get();
//                }
                        
                        if ($this->orderTab === null || $this->orderTab === 0) {
                            if ($this->orderDate === null) {
                                $orderDet = OrderDetails::where('orderType',0)->get();
                            } else {
                                $orderDet = OrderDetails::where('orderType',0)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                            }
                        } else {
                            if ($this->orderDate === null) {
                                $orderDet = OrderDetails::where('orderType', $this->orderTab)->get();
                            } else {
                                $orderDet = OrderDetails::where('orderType', $this->orderTab)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                            }
                        }
                        
                        $i = 1;
                        foreach ($orderDet as $order) {
                            $count = $order->getOrder($order->details_id)
                                ->join("products", "products.id", "=", "orders.product_id")
                                ->join("users", "users.id", "=", "orders.user_id")
                                ->join("units", "units.id", "=", "products.unit")
                                ->join("category", "category.id", "=", "products.category")
                                ->join("category_structures", "category_structures.id", "=", "orders.categoryStructure_id")
                                ->select("orders.*", "products.id as productId", "products.price as price", "users.name as userName", "users.id as userId", "category_structures.category as schoolName", "users.name as userName", "products.name as productName", "products.code", "units.unit", "category.name as categoryName")
                                ->where("category.story", "=", 0)
                                ->whereIn("users.id", $this->userId)
                                ->where("orders.status", "=", "approved")
                                ->get();
                            
                            if (count($count) != 0) {
                                if ($i == 1) {
                                    $row = 14;
                                    $rows = 14 + count($count) + 1;
                                } else {
                                    $row = $rows + 12;
                                    $rows = $row + count($count) + 1;
                                }
                                
                                
                                $event->sheet->getStyle("A$row:K$rows")->applyFromArray([
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
        }
        
        public function view(): View
        {
            
            if ($this->userId === null) {
//            $data = OrderDetails::all();
//            if($this->orderTab === null){
//                $data = OrderDetails::all();
//            }else{
//                $data = OrderDetails::where('orderType',$this->orderTab)->get();
//            }
                
                
                if ($this->orderTab === null || $this->orderTab === 0) {
                    if ($this->orderDate === null) {
                        $data = OrderDetails::where('orderType',0)->get();
                    } else {
                        $data = OrderDetails::where('orderType',0)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                    }
                } else {
                    if ($this->orderDate === null) {
                        $data = OrderDetails::where('orderType', $this->orderTab)->get();
                    } else {
                        $data = OrderDetails::where('orderType', $this->orderTab)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                    }
                }
                $arr = [];
                foreach ($data as $order) {
                    $obj = new \stdClass();
                    $obj->date = $order->created_at;
                    $obj->id = $order->id;
                    $obj->orders = $order->getOrder($order->details_id)
                        ->join("products", "products.id", "=", "orders.product_id")
                        ->join("users", "users.id", "=", "orders.user_id")
                        ->join("units", "units.id", "=", "products.unit")
                        ->join("category", "category.id", "=", "products.category")
                        ->join("category_structures", "category_structures.id", "=", "orders.categoryStructure_id")
                        ->select("orders.*", "products.id as productId", "products.price as price", "users.name as userName", "users.id as userId", "category_structures.category as schoolName", "users.name as userName", "products.name as productName", "products.code", "units.unit", "category.name as categoryName")
                        ->where("category.story", "=", 0)
                        ->get();
                    
                    $arr[] = $obj;
                    
                }
                $arr1 = [];
                if (!isset($arr)) {
                    echo "<script>window.close();</script>";
                }
                
                foreach ($arr as $order) {
                    foreach ($order->orders as $value) {
                        if ($value->status == 'approved') {
                            $obj1 = new stdClass;
                            $obj1->productName = $value->productName;
                            $obj1->count = $value->count;
                            $obj1->unit = $value->unit;
                            $obj1->code = $value->code;
                            $obj1->categoryName = $value->categoryName;
                            $obj1->exploiter = $value->exploiter;
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
            } else {
//            $data = OrderDetails::all();
//            if($this->orderTab === null){
//                $data = OrderDetails::all();
//            }else{
//                $data = OrderDetails::where('orderType',$this->orderTab)->get();
//            }
                
                
                if ($this->orderTab === null || $this->orderTab === 0) {
                    if ($this->orderDate === null) {
                        $data = OrderDetails::where('orderType',0)->get();
                    } else {
                        $data = OrderDetails::where('orderType',0)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                    }
                } else {
                    if ($this->orderDate === null) {
                        $data = OrderDetails::where('orderType', $this->orderTab)->get();
                    } else {
                        $data = OrderDetails::where('orderType', $this->orderTab)->where('created_at', '>=', $this->orderDateStart)->where('created_at', '<=', $this->orderDateEnd)->get();
                    }
                }
                $arr = [];
                foreach ($data as $order) {
                    
                    $obj = new \stdClass();
                    $obj->date = $order->created_at;
                    $obj->id = $order->id;
                    $obj->orders = $order->getOrder($order->details_id)
                        ->join("products", "products.id", "=", "orders.product_id")
                        ->join("users", "users.id", "=", "orders.user_id")
                        ->join("units", "units.id", "=", "products.unit")
                        ->join("category", "category.id", "=", "products.category")
                        ->join("category_structures", "category_structures.id", "=", "orders.categoryStructure_id")
                        ->select("orders.*", "products.id as productId", "products.price as price", "users.name as userName", "users.id as userId", "category_structures.category as schoolName", "users.name as userName", "products.name as productName", "products.code", "units.unit", "category.name as categoryName")
                        ->where("category.story", "=", 0)
                        ->whereIn("users.id", $this->userId)
                        ->get();
                    
                    $arr[] = $obj;
                    
                }
                $arr1 = [];
                
                foreach ($arr as $order) {
                    foreach ($order->orders as $value) {
                        if ($value->status == 'approved') {
                            
                            $obj1 = new stdClass;
                            $obj1->productName = $value->productName;
                            $obj1->count = $value->count;
                            $obj1->unit = $value->unit;
                            $obj1->code = $value->code;
                            $obj1->categoryName = $value->categoryName;
                            $obj1->exploiter = $value->exploiter;
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
    }