<?php

namespace App\Http\Middleware;

use App\Helper\AuthHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class InvoiceAdminMiddleware
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
        if (AuthHelper::check() && AuthHelper::user()->status == 'admin') {
            return $next($request);
        } else {
            return redirect()->route('invoice.index');
        }
    }
}
