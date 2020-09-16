<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class RolesMiddleware
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
        $url = request()->route()->uri();
        $role = Auth::user()->role_id;
        
   
        // developer-> 1
        // cliente-> 2
        // monitorista-> 3
        // trafico-> 4
        // chofer-> 5
        // master-> 6



        // CREAR USUARIOS
        // NO PUEDE monitorista, chofer, trafico ,cliente
        // SI PUEDE developer, cliente, master
 
        // CREAR DESPACHOS
        // NO PUEDE monitorista, chofer, cliente
        // SI PUEDE developer, master, trafico


        

        // CREAR CLIENTES
        // NO PUEDE monitorista, chofer, cliente
        // SI PUEDE developer, master, trafico


      



        return $next($request);
    }
}
