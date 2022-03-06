<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\AuthHelper;

class CheckManager
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
        if (AuthHelper::check()) {
            if (AuthHelper::user()->status == 'manager') {
                return $next($request);
            }

            AuthHelper::logout();
        }

//        return redirect()->route('admin_login_view');
        return redirect("/#/login");

    }
}
