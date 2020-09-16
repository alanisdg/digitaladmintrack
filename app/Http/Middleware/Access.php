<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Access
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
        public function handle($request, Closure $next, $role,$role2,$role3,$role4,$role5,$role6)
    {
        $user_rol =  Auth::user()->role_id;
        if($user_rol == $role){
            return $next($request);
        }
        if($user_rol == $role2){
            return $next($request);
        }
        if($user_rol == $role3){
            return $next($request);
        }
        if($user_rol == $role4){
            return $next($request);
        }
        if($user_rol == $role5){
            return $next($request);
        }
        if($user_rol == $role6){
            return $next($request);
        }
         
        return redirect('home');
        
    }
}
