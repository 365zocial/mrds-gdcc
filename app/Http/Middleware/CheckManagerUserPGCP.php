<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckManagerUserPGCP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    //Sorawit
    //Created : 9-6-59
    //Modified : -
    public function handle($request, Closure $next)
    {
        $role_id = Auth::user()->role_id;
        
        // 1 is Super Administrator, 3 is Manager, 5 is User, 6 is PGCP
        if( $role_id == 1 || $role_id == 3 || $role_id == 5 || $role_id == 6 ) {
            return $next($request);
        }
        
        return redirect('logout');
    }
}
