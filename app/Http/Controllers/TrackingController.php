<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use App\Packets;
use App\Travels;
use App\Tcodes;
use App\Thits;
use App\Signes;
use App\Geofences;
use App\Routes;
use View;
use Auth;
use DB;
use Carbon\Carbon;

class TrackingController extends BaseController
{
    use DevicesTraits;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $available_devices;

    public function __construct()
    {

    }

    public function index(){
        return view('tracking.index');
    }

    public function get_tracking(){
        $code = Tcodes::where('code',request()->get('code'))->first();
        if($code == null){
           return redirect('/tracking')->with('code','no encontrado');
        }
        $travel = Travels::where('tcode_id',$code->id)->first();

        $device = Devices::find($travel->device_id);


        $g =  DB::table('thits')->where('tcode_id',request()->get('code'))->toSql();
         
        $hits = Thits::where('tcode_id',$code->id)->get();
      


        $geofences = Signes::where('device_id',$travel->device_id)->whereBetween('updateTime',[$travel->departure_date,$travel->arrival_date])->get();


        $destination = $travel->route->destination_id;
        $origin = $travel->route->origin_id;
        $real_departure = '';
        $real_arrival='';
        foreach ($geofences as $geofence) {
            if($geofence->geofence_id == $origin AND $geofence->status==0){
                $real_departure = $geofence->packet->updateTime;
            }
            if($geofence->geofence_id == $destination AND $geofence->status==1){
                $real_arrival = $geofence->packet->updateTime;
            }
        }
        if($real_arrival==''){
            $real_arrival = 'Pendiente';
        }
        if($real_departure==''){
            $real_departure = 'Pendiente';
        }

        //informacion de la ruta
        $route = Routes::find($travel->route->id);
        $geofences = array();
        $geofences_route = array();

        $o = Geofences::find($origin);
        array_push($geofences_route,$o);

        $references = $route->references_route;
        $ref = json_decode($references,true);
        foreach ($ref as $value) {
            foreach ($value as $key => $val) {
                $geo = Geofences::find($key);
                array_push($geofences,$geo);
                array_push($geofences_route,$geo);
            }
        }
        $d = Geofences::find($destination);
        array_push($geofences_route,$d);

        return view('tracking.tracking',compact('travel','device','real_departure','real_arrival','geofences','geofences_route','hits'));
    }


}
