<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $arr = $request->validated();


        $arr1 = ['name'=>$arr['name'], 'email'=>$arr['email'], 'password'=>bcrypt($arr['password'])];

        return $this->respondWithToken(
            auth()->login(
                User::create($arr1)
            )
        );
    }
}
