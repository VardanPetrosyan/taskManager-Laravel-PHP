<?php
    
    namespace App\Http\Controllers\Admin;
    
    use App\Exports\OrderExcelExports;
    use App\Models\Orders;
    use App\Models\Units;
    use App\Models\OrderDetails;
    use App\Models\Product;
    use App\Models\User;
    use App\Exports\OrdersExport;
    
    use Maatwebsite\Excel\Facades\Excel;
    
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    
    class OrdersExportController extends Controller
    {
        public function excel(Request $request)
        {
           
            $userstrid = $request->get('user_Id');
            $orderTab = $request->get('orderTab');
            $orderDate = $request->get('orderDate');
            
//        dd($orderDate);
            if ($orderTab == 'orders' || $orderTab == null) {
                $orderTab = 0;
            } elseif ($orderTab == 'claim-orders') {
                $orderTab = 1;
            }
            
            if ($userstrid != null) {
                $userstrid = explode(',', $userstrid);
                $userId = [];
                foreach ($userstrid as $v) {
                    $userId[] = $v;
                };
            } else {
                $userId = null;
            }
//            dd($userId);
            ini_set('max_execution_time', -1);
            return Excel::download(new OrderExcelExports($userId, $orderTab, $orderDate), 'Հաշվետվություն.xlsx');
        }
    }
