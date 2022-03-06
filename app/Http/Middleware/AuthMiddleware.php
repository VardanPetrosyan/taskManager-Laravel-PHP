<?php

namespace App\Http\Middleware;

use App\Helper\AuthHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(AuthHelper::check()) {
            if(AuthHelper::user()->status == 'admin') {
                return redirect()->route('invoice.admin.dashboard');
            } else {
                return $next($request);
            }
        } else {
            return redirect()->route('invoice.login');
        }

    }
}
