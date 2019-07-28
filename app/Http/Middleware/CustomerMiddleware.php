<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Enumeration\RoleType;

class CustomerMiddleware
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
        $admin = RoleType::$ADMIN;
        $customer = RoleType::$CUSTOMER;
        $staff_customer = RoleType::$STAFF_CUSTOMER;

        if (Auth::check() && Auth::user()->role == $customer ){
            return $next($request);
        }
        else
        {
            return redirect()->route('login');
        }
    }
}
