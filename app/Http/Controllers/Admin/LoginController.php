<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helper\AuthHelper;


class LoginController extends Controller
{
    public function index()
    {
        return view("admin.login");
    }

    public function login (Request $request) 
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
            
        $admin = User::where('email', $request->post('email'))
            ->first();

        if (is_null($admin) || !Hash::check($request->post('password'), $admin->password)) {
            return back()->withErrors([
                'errors' => 'Այսպիսի գաղտնաբառ գոյություն չունի',
            ]);
        }

        if($admin->status == User::STATUS_ADMIN || $admin->status == User::STATUS_MANAGER){
            AuthHelper::login($admin);
            if($admin->status == User::STATUS_ADMIN){
                return redirect()->route('admin_dashboard');
            }else if($admin->status == User::STATUS_MANAGER){
                return redirect()->route('manager_dashboard');
            }
        }else {
            return back();
        }

    }

    public function logout () 
    {
        AuthHelper::logout();
        return redirect()->to('/');
    }

}
