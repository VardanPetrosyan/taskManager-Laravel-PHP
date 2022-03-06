<?php

namespace App\Http\Controllers\Admin;

use App\Helper\AuthHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    public function info()
    {

        $adminId = Session::get('logged_admin_id');

        return view('_layouts.admin')->with(['adminId' => $adminId]);

    }
}
