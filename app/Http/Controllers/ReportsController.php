<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Devices;
use App\Packets;
use App\User;
use Auth;
use Carbon\Carbon;

class reportsController extends Controller
{
    use DevicesTraits;
    public function __construct()
    { 
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        //$devices = Devices::where('client_id',Auth::user()->client_id)->where('type_id',1)->get();
        $devices = $user->getAllDevices($user);
        return view('reports',compact('devices'));
    }
    public function get()
    {
         

             
        //dd(request()->all());
        $this->validate(request(),[
            'date_init' => ['required'],
            'date_end' => ['required']
        ]);
        $init = request()->get('date_init') . " " . request()->get('hour_init');
        $end = request()->get('date_end') . " " . request()->get('hour_end');

 $device = Devices::where('imei',request()->get('imei'))->first();
        $packets = Packets::where('devices_id',$device->id)
                    ->whereBetween('updateTime', array($init, $end))
                    ->get();
                    //dd($packets);
if(count($packets)==0){

              return response()->json([
            'report'=> 0
        ]);
}else{
$report = $this->parseReport($packets,$device->id,$init,$end);
              return response()->json([
            'report'=>$report
        ]);
}
             
        


         





    }
}
