<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\OrderExcelExportsManager;
use App\Exports\OrderExcelExports;
use Maatwebsite\Excel\Facades\Excel;

class OrdersExportController extends Controller
{
//    public function excel() {
//    	return Excel::download(new OrderExcelExportsManager, 'Հաշվետվություն.xlsx');
//	}


    public function excel(Request $request) {
        $userstrid = $request->get('user_Id');
        $orderTab = $request->get('orderTab');
        if($orderTab=='orders'){
            $orderTab = 0;
        }elseif ($orderTab=='claim-orders'){
            $orderTab = 1;
        }
        if($userstrid != 'null'){
            $userstrid = explode(',' , $userstrid);
            $userId=[];
            foreach($userstrid as $v){
                $userId[]=$v;
            };
        }else{
            $userId = null;
        }
        return Excel::download(new OrderExcelExports($userId,$orderTab), 'Հաշվետվություն.xlsx');
    }
}
