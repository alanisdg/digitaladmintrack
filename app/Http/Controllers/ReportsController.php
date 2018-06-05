<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Devices;
use App\Packets;
use App\Geofences;
use App\Signes;
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

    public function geocercas()
    {
        $user = User::find(Auth::user()->id);
        //$devices = Devices::where('client_id',Auth::user()->client_id)->where('type_id',1)->get();
        $devices = $user->getAllDevices($user);
        $geofences = Geofences::where('id_client',$user->client_id)->get();
        
        return view('reportesgeocercas',compact('devices','geofences'));
    }

    public function get_geofences()
    {   $this->validate(request(),[
            'date_init' => ['required'],
            'date_end' => ['required']
        ]);
        $init = request()->get('date_init') . " " . request()->get('hour_init');
        $end = request()->get('date_end') . " " . request()->get('hour_end');
        $geofence_ = Geofences::where('id',request()->get('geofence_id'))->get();
        $geofences = Signes::where('geofence_id',request()->get('geofence_id'))->where('device_id',request()->get('device_id'))->whereBetween('updateTime', array($init, $end))->get();
        $table = '';
        $device = Devices::find(request()->get('device_id'));
        $device_name = $device->name;
        foreach ($geofences as $geofence) {
            if($geofence->status == 1){
                $status = 'Entro';
            }elseif($geofence->status == 0){
                $status = 'Salio';
            }
            $table .= '<tr><td>'.$geofence->geofence->name.'</td><td>'.$status.'</td><td>'.$geofence->updateTime.'</td><td>'.$device_name.'</td></tr>';
        }
        return response()->json([
            'Geofences'=>$table,
            'Geofence'=>$geofence_
        ]);
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
