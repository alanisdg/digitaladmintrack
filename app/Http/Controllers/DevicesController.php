<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Devices;
use App\Clients;
use App\Packets;
use App\Routes;
use App\Geofences;
use App\User;
use Carbon\Carbon;
use Auth;
use DB;
/**
 *
 */


class DevicesController extends Controller
{
    use DevicesTraits;

    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function updateDevice(){
        $id = request()->get('id');
        $device = Devices::find($id);
        $device->name = request()->get('name');
        $device->save();
        return redirect()->to('/device/'.$id);

    }

    public function clean(){
      
        $ayer = Carbon::yesterday();
         $user = User::find(1);
         $user->name = 'Horacio Cron 4';
            $user->save();
            
        DB::table('packets_lives')->where('updateTime', '<', $ayer)->delete();

    }

    public function updateBlock(){
        $id = request()->get('device_id');
        $now = Carbon::now('America/Monterrey');
        $device = Devices::find($id);
        $device->elock = 1;
        $device->stepBlock = request()->get('step');
        $device->bbuton = $now;
        $device->save(); 
        return response()->json([
            'devices'=>$now
        ]);
    }
    public function getPanic(){
        $id = request()->get('id');
   
        $packet = Packets::where('devices_id',$id)->where('eventCode',61)->limit(1)->orderBy('id', 'DESC')->get();
        return response()->json([
            'panic'=>$packet
        ]);
    }
     public function finishPanic(){
        $id = request()->get('id');
   
        $device = Devices::find($id);
        $device->panic = 0;
        $device->save();
        return response()->json([
            'panic'=>'finish'
        ]);
    }
    
    public function devices(){
        $devices = Devices::all();
        $user = User::find(Auth::user()->id);
        return view('admin.devices.devices', compact('devices','user'));
    }

    public function device($id){
        $device = Devices::find($id);
        $user = User::find(Auth::user()->id);
        return view('devices.device', compact('device','user'));
    }

    


    public function trucksget( ){




        $route_id = request()->get('id');
        $route = Routes::find($route_id);

        $geofence_name = $route->origin->name;

        $origin_id = $route->origin_id;

        $devices = Devices::where('client_id',Auth::user()->client_id)->get();
        $boxes = Devices::where('client_id',Auth::user()->client_id)->where('type_id',2)->get();
        $devices_in = array();
        $boxes_in = array();


        //BUSCAR UNIDADES DISPONILES DENTRO DE LA GEOCERCA
        foreach ($devices as $device) { 
            if($device->geofences !=null){
                $geofences = json_decode($device->geofences,true) ;

                foreach ($geofences as $geofence => $valor) {
                    if($origin_id == $geofence){
                        if($valor == 1){
                            array_push($devices_in,$device->id);
                        }
                        break;
                    }
                }
            }
        }

        /*DESCOMENTAR PARA DETECTAR CAJAS EN GEOCERCAS
        //BUSCAR CAJAS DISPONILES DENTRO DE LA GEOCERCA
        foreach ($boxes as $box) {
            // SI LA CAJA ES NUEVA Y VIRTUAL, AGREGARLA
            if($box->new==1 AND $box->virtual==1){
                array_push($boxes_in,$box->id);
            }
            if($box->geofences !=null){
                $geofences = json_decode($box->geofences,true) ;

                foreach ($geofences as $geofence => $valor) {
                    if($origin_id == $geofence){
                        if($valor == 1){
                            array_push($boxes_in,$box->id);
                        }
                        break;
                    }
                }
            }
        }
        $boxes = Devices::whereIn('id', $boxes_in)->where('status',0)->get();
        */

        //AGREGAR CAJAS NUEVAS QUE NO TENGAN REPORTES

        $devices = Devices::whereIn('id', $devices_in)->where('status',0)->get();


        return response()->json([
            'devices'=>$devices,
            'geofence'=>$geofence_name
            //'boxes'=>$boxes
        ]);



    }
    public function trucks(){
        
        $user = User::find(Auth::user()->id);
        

        if($user->role_id==1){
             
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $trucks = $client->devices;

        }else {
            $trucks = $user->devices_by_user;
        }


        $geofences = Geofences::where('id_client',Auth::user()->client_id)->get();

        return view('devices.trucks', compact('trucks','geofences'));
    }

    public function get_trucks_by_geofence( ){
        $id = request()->get('id');

        $user = User::find(Auth::user()->id);
        

        if($user->role_id==1){
             
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $trucks = $client->devices;

        }else {
            $trucks = $user->devices_by_user;
        }


        if($id == 'all'){

             
            return response()->json([
                'devices'=>$trucks
            ]);
        }
         

        $devices=array();
        foreach ($trucks as $truck) {
            if($truck->geofences !=null){
            $geofences = json_decode($truck->geofences,true) ;
                foreach ($geofences as $geofence => $valor ) {
                    if($geofence == $id){
                        if($valor == 1){
                            array_push($devices,$truck->id);
                        }
                    }
                }
            }
        }
        $devices = Devices::whereIn('id', $devices)->get();
        return response()->json([
            'devices'=>$devices
        ]);
    }

    public function boxes(){
        $boxes = Devices::where('client_id',Auth::user()->client_id)
                    ->where('type_id',2)->get();
        return view('devices.boxes', compact('boxes'));
    }


    public function create(){
        $clients = Clients::all();
        $user = User::find(Auth::user()->id);
        return view('admin.devices.create',compact('clients','user'));
    }

    public function delete(){
        // dd($id);
        $id = request()->all();

        $packets = Devices::where('id', $id)->delete();

        //Device::find(request()->get('id'))->delete();
        return response()->json($id);

    }

    public function store(){
        $data = request()->all();
        $device = Devices::create($data);
        $id = array(request()->get('client_id'));
        $device->clients()->sync($id);
        //flash('Device '.request()->get('name').' creada!');
        return redirect()->to('dashboard/devices');
    }
    public function read($id){
        $clients = Clients::all();

        $device = Devices::find($id);
        $user = User::find(Auth::user()->id);

        $client = Clients::find($device->client_id);
        return view('admin/devices/read', compact('device','clients','user','client'));
    }

    public function sms($id){
        $clients = Clients::all();

        $device = Devices::find($id);
        $user = User::find(Auth::user()->id);
        return view('admin/devices/sms', compact('device','clients','user'));
    }

    public function boxs(){
        $geofences = Geofences::where('id_client',Auth::user()->client_id)->where('gcat_id',1)->get();
        $patios = Geofences::where('id_client',Auth::user()->client_id)->where('gcat_id',2)->get();
        $user = User::find(Auth::user()->id);
        $boxs = $user->getBoxes($user); 
         
        return view('devices/boxs', compact('boxs','geofences','patios'));
    }


    public function update(){
            $device = Devices::find(request()->get('id'));

            $device->clients()->sync(request()->get('clients'));
            $device->name = request()->get('name');
            $device->imei = request()->get('imei');
            $device->plate = request()->get('plate');
            $device->type_id = request()->get('type_id');
            $device->number = request()->get('number');
            $device->client_id = 1;
            if(request()->get('virtual')==null){
            $device->virtual = 0;
            }else{
            $device->virtual = 1;
            }

            if(request()->get('engine_block')==null){
            $device->engine_block = 0;
            }else{
            $device->engine_block = 1;
            }


            $device->save();
            $clients = Clients::all();
            $device = Devices::find(request()->get('id'));
            flash('Device '.request()->get('name').' actualizado!');
            // return view('admin/devices/read', compact('device','clients'));
            return redirect()->to('dashboard/devices');
    }

}