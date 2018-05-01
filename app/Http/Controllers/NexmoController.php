<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use Auth;
use DB; 
use Carbon\Carbon;
use Nexmo;

class NexmoController extends Controller
{
     
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function send()
    { 

       $number = request()->get('number');
        $code = request()->get('code');
        $device_id = request()->get('device_id');
      
        $test = Nexmo::message()->send([
            'to' => '+521'.$number,
            'from' => 'NEXMO SMS',
            'text' => $code
        ]); 
        dd($test);
          return response()->json($test);
 
    }

}
