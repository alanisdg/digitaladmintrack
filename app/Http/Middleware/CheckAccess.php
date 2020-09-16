<?php

namespace App\Http\Middleware;

use Closure;
use App\Clients;
use Auth;
class CheckAccess
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
        $id = Auth::user()->client_id;
        $client = Clients::where('id',$id)->get();
       
        if($client[0]->access == 1){
            Auth::logout();
            return redirect('/aviso');
        }
        return $next($request);
    }
}
