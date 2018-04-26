<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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

        // 1 is Super Administrator, 2 is Administrator
        if( $role_id == 1 || $role_id == 2 ) {
            return $next($request);
        }

        return redirect('logout');
    }
}
