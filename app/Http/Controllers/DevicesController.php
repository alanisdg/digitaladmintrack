<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Devices;
use App\Clients;
use App\Pops;
use App\Wheels;
use App\Packets; 
use App\Packets_history; 
use App\Routes;
use App\Signes;
use App\Geofences;
use App\User;
use App\Notifications;
use App\Alerts;
use App\Reports_day;
use App\States;
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

    public function insertcoment(){ 

        $coment['comentario'] =  'hola';
        $coment['user_id'] = 1;
        $coment['devices_id'] = 26;


        $user = User::find(1);
        $coment['user_name'] = $user->name;


         
         
        $coment['comentario'] =  request()->get('message');
        $coment['user_id'] = request()->get('user_id');
        $coment['devices_id'] = request()->get('id');


        $user = User::find(request()->get('user_id'));
        $coment['user_name'] = $user->name;
        
        


        $pop = Pops::create($coment);
         //dd($pop->id);
        $users = User::where('id','!=',Auth::user()->id)->where('client_id',Auth::user()->client_id)->get();
        foreach($users as $user){
            $user->read=1;
            $new_notification = $user->new_notifications + 1;
            $user->new_notifications = $new_notification;
            $user->save();

            $notification = Notifications::create([
                'client_id' =>Auth::user()->client_id,
                'nde_id'=>2,
                'user_id'=>$user->id,
                'author_id'=>Auth::user()->id,
                'device_id' => request()->get('id'),
                'pop_id' => $pop->id
            ]);
        }



        $user  = $pop->user;
        $coment['user'] = $user; 
        $coment['updateTime'] = $pop->timeago($pop->created_at);
        
        //$coment = 0;
        //$device->save();
        return response()->json([
            $coment
        ]);

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
   
        $packet = Packets::where('devices_id',$id)->where('eventCode',60)->limit(1)->orderBy('id', 'DESC')->get();
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
    public function stopJammer(){
      
        $device = Devices::find(request()->get('id'));
        $device->jammer=0;
        $device->save();
        return response()->json([
            $device
        ]);

    }
    public function devices(){
        //$devices = Devices::all();
        $user = User::find(Auth::user()->id);
        $clients = Clients::all();
         
        return view('admin.devices.devices', compact('devices','user','clients'));
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

    public function getDevicesByClient(){
        $id =  request()->get('id') ;
        $devices = Devices::where('client_id',$id)->get();
        $r = '';
        $r= '<thead>
                    <td>Id</td>
                    <td>Nombre</td>
                    <td>Imei</td>
                    <td>Número</td>
                    <td>Placa</td>
                    <td>Cliente(s)</td> 
                    <td>Estado</td>
                    <td></td>
                    <td></td>
                    <td>Paquetes</td>
                    <td>sms</td>
                </thead>';
        foreach($devices as $device){
            $r .= '<tr class=>';
            $r.= '<td>' . $device->id .'</td>';
            $r.='<td>'. $device->name .'</td>
                        <td>' . $device->imei .'</td>
                        <td>' . $device->number .'</td>
                        <td>' . $device->plate .'</td><td>' ;

                         foreach($device->clients as $client){
                            $r .= $client->name . ', ';
                        } 
                            
                            
                        $r .= '</td> ';

                        $r.= '<td>' . $device->statusadmin($device) . '</td>';
                        $r.='<td>
                            <a href="/dashboard/devices/read/' . $device->id .'">ver</a>
                        </td>
                        <td>
                            <a  class="delete_device btn btn-danger btn-xs" ide="' . $device->id .'" >Eliminar</a>

                        </td>
                        <td><a href="/dashboard/packets/'. $device->id .'">Ver</a></td>
                        <td>
                            <a href="/dashboard/devices/sms/'. $device->id .'">SMS</a>
                        </td>';
 
            $r.= '<tr>';
        }
                       
                      
        return response()->json($r);
    }

    public function getlts(){

        $voltmenor = 0;
          $litrosmenor = 0;
        $tank = request()->get('tank'); 
        $device_id = request()->get('device_id');

        $device = Devices::find($device_id);
        $volt_report = request()->get('volts');  
       if($volt_report == 0){
            return response()->json(0);
        }
        //$volt_report = $volt_report / 1000;
        if($tank == 1){
            $calibration = json_decode($device->calibration1,true);
        }
        if($tank == 2){
            $calibration = json_decode($device->calibration2,true);
        }
        if($tank == 3){
            $calibration = json_decode($device->calibration3,true);
        }
        //dd($calibration);
foreach ($calibration as $k => $value) {
            foreach ($value as $volt => $lts) {
                $lastlts = $lts;
            }
        }
       
        foreach ($calibration as $k => $value) {
            foreach ($value as $volt => $lts) {
                if($volt_report <= $volt){
                    $voltmayor = $volt;
                    //dd($voltmenor);
                    $litrosmayor = $lts;

                    $diferenciadevolts = $voltmayor - $voltmenor; 
            $diferenciadelitros = $litrosmayor - $litrosmenor; 
            $voltsporcalcular = $volt_report - $voltmenor; 

            $a = $voltsporcalcular * $diferenciadelitros;
            
            $a = $a/$diferenciadevolts;
            
            $litros = $a + $litrosmenor;
             
$p = $litros * 100;
            $percent = $p / $lastlts;
            return response()->json([
            'litros' =>$litros,
            'percent' =>$percent
        ]); 


                }

                $voltmenor = $volt;
          $litrosmenor = $lts;

            }
        }


        
         
    }
    public function calibration($device_id,$tank_){
        $device = Devices::find($device_id);
        $tank = $tank_;
        $user = User::find(Auth::user()->id);
        return view('admin.devices.calibration', compact('device','tank','user'));
    }

    public function insertCalibration(){
        //dd(request()->all());
        $calibration = array();
        $par = 1;
        foreach (request()->all() as $key => $value) {
            if($key == '_token' OR $key == 'device_id' OR $key == 'tank'){
                continue;
            }
            if($value == ''){
                continue;
            }

            if($par == 1){
                $volt = $value;

                $par = 2;
                continue;
            }
            if($par == 2){
                $litros = $value;
                $field[$volt] = $litros;
                array_push($calibration, $field);
                $field = '';
                $litros = '';
                $volt = '';
                $par = 1;
                //dd($litros);
            }
           
           /* $field[$key] = $value;

            array_push($calibration, $field);*/

             
            
        }

       

        $calibration  = json_encode($calibration);
        $device_id = request()->get('device_id');
        $device = Devices::find($device_id);
        if(request()->get('tank') == 1){
            $device->calibration1 = $calibration;
        }
        if(request()->get('tank') == 2){
            $device->calibration2 = $calibration;
        }
        if(request()->get('tank') == 3){
            $device->calibration3 = $calibration;
        }
        $device->save();
        return redirect()->to('dashboard/devices/read/'.$device_id);
    }

    public function update(){
            
            $device = Devices::find(request()->get('id'));

            $device->clients()->sync(request()->get('clients'));
            $device->name = request()->get('name');
            $device->charge_from = request()->get('charge_from');
            if(request()->get('stop_from') == ''){
                $device->stop_from = null;
            }else{
               $device->stop_from = request()->get('stop_from'); 
            }
            
            $device->imei = request()->get('imei');
            $device->plate = request()->get('plate');
            $device->type_id = request()->get('type_id');
            $device->number = request()->get('number');
            $device->client_id = request()->get('property');
            if(request()->get('virtual')==null){
            $device->virtual = 0;
            }else{
            $device->virtual = 1;
            }

            if(request()->get('fuel')==null){
            $device->fuel = 0;
            }else{
            $device->fuel = 1;
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