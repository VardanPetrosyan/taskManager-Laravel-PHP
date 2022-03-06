<?php

namespace App\Http\Controllers\Invoice;

use App\Models\Invoice\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function getEmail(Request $request) {
        $email = $request->email;
        $html = view('invoice.forgetPassword.password_email', compact('email'))->render();

        return response()->json(['html' => $html, 'status' => true]);
    }

    public function postEmail(Request $request) {
        $mailName = config('mail.username');;
        $request->validate([
            'email' => 'required|email',
        ]);
        $token = uniqid() . Str::random(60);
        $email = $request->email;
        PasswordReset::insert([
           'email' => $request->email,
           'token' => $token,
           'created_at' => Carbon::now()
        ]);

        Mail::send('invoice.forgetPassword.verify',['token' => $token, 'email' => $email], function($message) use ($email, $mailName) {
            $message->to($email)->subject('Reset Password Notification');

            $message->from($mailName);
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function getPassword($token, Request $request) {
        $email = $request->email;
        return view('invoice.forgetPassword.reset', compact('token', 'email'));
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:3|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = PasswordReset::where('email', $request->email)->where('token', $request->token)->first();
        if(!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('invoice.login')->with('message', 'Your password has been changed!');
    }
}
