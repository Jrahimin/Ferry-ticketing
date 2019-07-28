<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Enumeration\RoleType;

class CompanyUserMiddleware
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
        if (Auth::check() && (Auth::user()->role == RoleType::$COMPANY_USER 
            || Auth::user()->role == RoleType::$ADMIN)) {

            return $next($request);
        }
        else {
            abort('401', 'unauthorized');
        }
    }
}
