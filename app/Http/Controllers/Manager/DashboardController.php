<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders;

class DashboardController extends Controller
{
    public function index () 
    {
    	$orderPending = Orders::where('status', Orders::STATUS_PENDING)->count();
        $orderComplete = Orders::where('status', Orders::STATUS_COMPLETE)->count();
        $orderArchive = Orders::where('status', Orders::STATUS_ARCHIVE)->count();
        $orderCanceledByAdmin = Orders::where('status', Orders::STATUS_CANCELED_BY_ADMIN)->count();
        $orderCanceledByCustomer = Orders::where('status', Orders::STATUS_CANCELED_BY_CUSTOMER)->count();
        $orderTotal = $orderArchive + $orderCanceledByAdmin + $orderCanceledByCustomer + $orderComplete + $orderPending;

    	return view('manager.dashboard', [
    		'orderPending' => $orderPending,
            'orderComplete' => $orderComplete,
            'orderArchive' => $orderArchive,
            'orderCanceledByAdmin' => $orderCanceledByAdmin,
            'orderCanceledByCustomer' => $orderCanceledByCustomer,
            'orderTotal' => $orderTotal,
    	]);
    }
}
