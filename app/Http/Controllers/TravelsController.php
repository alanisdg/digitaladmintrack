<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Geofences;
use App\Travels;
use App\Drivers;
use App\Notifications;
use App\Devices;
use App\Locations;
use App\Toclients;
use App\Routes;
use App\Comments;
use App\Tcodes;
use App\Subclients;
use App\Packets;
use App\User;
use App\Signes;
use Auth;
use DB;
use Session;
use Redirect;
use Carbon\Carbon;

class TravelsController extends Controller
{
    use DevicesTraits;
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }
    public function index()
    {
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');

        $start = new Carbon('last day of last month');
        $end = new Carbon('first day of next month');


        $travels = Travels::where('travels.client_id',Auth::user()->client_id)
                ->where('tstate_id','!=',7) 
                ->where('tstate_id','!=',5) 
                ->where('tstate_id','!=',4) 
                ->whereBetween('arrival_date',array($start,$end))
                ->orderBy('created_at', 'asc')
                ->get();
        $drivers = Drivers::where('client_id',Auth::user()->client_id)->get();
        $devices = Devices::where('client_id',Auth::user()->client_id)->get();
        return view('travels.index',compact('travels','drivers','devices'));
    }
    public function orders()
    {
        $orders = Travels::where('travels.client_id',Auth::user()->client_id)
                ->where('tstate_id',5)
                ->where('active',1)
                ->orderBy('arrival_date', 'asc')
                ->get();
        return view('travels.orders',compact('orders'));
    }
    public function traveltest()
    {
        return view('travels.try');
    }
    public function get_travels_by(){
        //PENDIENTITO
        
        if(request()->get('by')=='date'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->whereBetween('arrival_date',array(request()->get('init'),request()->get('end') ))->get();
        }
        $start = new Carbon('last day of last month');
        $end = new Carbon('first day of next month');
        if(request()->get('by')=='driver'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->where('driver_id',request()->get('driver_id'))->get();
        }

        if(request()->get('by')=='device'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->where('device_id',request()->get('device_id'))->get();
        }


        if(request()->get('by')=='reference'){
            $travels = array();
            $travels_find= Travels::all();
         
            foreach ($travels_find as $travel) {
                $ex = json_decode($travel->reference);
               
               foreach ($ex as $explode) {
                   if(request()->get('reference')==$explode){
                    $travels = Travels::find($travel->id)->get();
                   }
               }
            }
             
        }



        if(request()->get('by')=='route'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->where('tstate_id',2)->whereBetween('arrival_date',array($start,$end))->get();
        }

        if(request()->get('by')=='cancel'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->where('tstate_id',7)->whereBetween('arrival_date',array($start,$end))->get();
        }

        if(request()->get('by')=='togo'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->where('tstate_id',1)->whereBetween('arrival_date',array($start,$end))->get();
        }
        if(request()->get('by')=='end'){
            $travels= Travels::where('client_id',Auth::user()->client_id)->where('tstate_id',4)->whereBetween('arrival_date',array($start,$end))->get();
        }

        $t ='';
        foreach($travels as $travel){


        $t .='<tr>';
            if(isset($travel->tcode->code)){
                $t .='<td>'.  ucfirst($travel->tcode->code)  .'</td>';
            }

            if(isset($travel->route->name)){
                $t .='<td>'.ucfirst($travel->route->name).'</td>';
            }else{
                $t .='<td>Sin ruta asignada</td>';
            }

            if(isset($travel->device->name)) {
                $t .='<td>'.ucfirst($travel->device->name).'</td>';
            }else{
                $t .='<td>Sin equipo asignado</td>';
            }


            if(isset($travel->driver->name)){
                $t .='<td>'.ucfirst($travel->driver->name).'</td>';
            }else{
                $t .='<td>Sin chofer asignado</td>';
            }




            if(isset($travel->box->name)){
                $t .='<td>'.$travel->box->name.'</td>';
            }else{
                $t.='<td>Sin caja</td>';
            }

            if(isset($travel->additionalbox->name)){
                $t .='<td>'.$travel->additionalbox->name.'</td>';
            }else{
                $t.='<td>Sin caja</td>';
            }




            if($travel->tstate_id == 2){
                $t.='<td>'.$travel->device->leftTime($travel->arrival_date) .'</td>';
            }

            if($travel->tstate_id == 1){
                $t.='<td>'.$travel->device->leftTime($travel->departure_date) .'</td>';
            }




            if($travel->tstate_id == 4 OR $travel->tstate_id == 7 ){
                $t.='<td> - </td>';
            }


            $t.='<td>
                <span class="badge travel_'.$travel->tstate->id .'">'.$travel->tstate->name .'</span>
            </td>
            <td><a class="btn btn-primary btn-xs" href="/travel/'.$travel->tcode->id .'">Ver</a></td>
            <td>';
                if($travel->tstate_id != 7 ){
                    $t.='<a class="btn btn-primary btn-xs cancel_travel"  ide="'.$travel->id.'">Cancelar</a>';
                }


            $t.='<td> <a class="btn btn-primary btn-xs" href="/travel/edit/'.$travel->id .'">Editar</a></td></td>
        </tr>';
        }
        return response()->json($t);
    }
    public function delete_order(){
        //return response()->json(request()->get('id'));
        $travel_id = request()->get('id');
        $travel = Travels::where('tcode_id',$travel_id)->first();
        $travel->delete();
        return response()->json('eliminado');
    }

    public function edit($id){
      $travel = Travels::find($id);

        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $devices = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $boxes = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',2)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $subclients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();

        $location = Locations::find( $travel->location_id);
        $locations = Locations::where('locations.subclients_id',$travel->subclient_id)->get();


        $destinations = Toclients::where('subclients_id',$travel->subclient_id)->get();
 
/*
        $toclient = Toclients::find( $travel->toclient_id);

        $toclients = Toclients::where('subclients_id',$travel->subclient_id)->get();

*/

        $routes = Routes::where('routes.client_id',Auth::user()->client_id)
                    ->where('destination_id',$travel->location->geofences->id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $arrival = explode(' ' , $travel->arrival_date);
        $arrival_year = $arrival[0];
        $arrival_hour = $arrival[1];

        $route_saved = Routes::find($travel->route_id);
        $destination_saved = Routes::find($travel->destination_id);
        $driver_saved = Drivers::find($travel->driver_id);

        $device_saved = Devices::find($travel->device_id);
        $box_saved = Devices::find($travel->box_id);

        $references = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->where('gcat_id',4)
                ->orderBy('created_at', 'asc')
                ->get();


        return view('travels.edit',compact('devices','drivers','references','routes','subclients','travel','location','locations','arrival_year','arrival_hour','boxes','route_saved','driver_saved','device_saved','box_saved','destination_saved','destinations'));
    }

    public function editsave(){ 
        $travel = Travels::find(request()->get('travel_id'));
        $travel->departure_date =request()->get('init');
        $travel->arrival_date =request()->get('end');


        $ref=1;
        $references = array();
        foreach (request()->all() as $key => $value) {
            if($key == 'route-ref-id-'.$ref){
                $ide = request()->get('estimated-hour-'.$ref);
                $reference = array($value => $ide);
                array_push($references,$reference);
                $ref++;
            }

        }
         
        if(request()->get('route_id')!=''){
        $client_id = request()->get('client_id');
        $origin_id = request()->get('origin_id');
        $location_id = request()->get('location_id');

         
        $origin_location = Locations::find($origin_id);
        $origin = Geofences::find($origin_location->geofences_id);
          
        $location = Locations::find($location_id);
        $destination = Geofences::find($location->geofences_id);
        $name = $origin->name . " - " . $destination->name;
        
        if(request()->get('route_id')!='Selecciona una ruta'){
            
            $route =  Routes::find(request()->get('route_id'));
        }else{
            $route =  Routes::create([
                    'name' => $name,
                    'client_id' =>$client_id,
                    'origin_id' => $origin->id,
                    'destination_id' => $destination->id,
                    'references_route'=>json_encode($references)
                ]);
        }

        $travel->location_id = request()->get('location_id');
        
        $travel->route_id = $route->id; 
        $travel->tstate_id = $this->getTravelStatusByGeofence2($travel->departure_date ,$travel->arrival_date,request()->get('device_id'),$route->id);


        $travel->save(); 
        return redirect()->to('/travels');
    }else{


        $travel->location_id =request()->get('location_id');
        $destination_id = request()->get('location_id');

        //PENDIENTE
        $travel->tstate_id = $this->getTravelStatusByGeofence2($travel->departure_date ,$travel->arrival_date,request()->get('device_id'),request()->get('old_route_id'));
        $travel->save();
        return redirect()->to('/travels');
        
    }

  
 

        /*
        // DRIVER
        if($travel->driver_id != request()->get('driver_id')){
            // ACTUALIZAR CHOFER

            $driver = Drivers::find(request()->get('driver_id'));
            $driver->status=0;
            $driver->save();
        }
        $travel->driver_id =request()->get('driver_id');


        //DEVICE
        if($travel->device_id != request()->get('device_id')){
            // ACTUALIZAR CHOFER

            $device = Devices::find(request()->get('device_id'));
            $device->status=0;
            $device->save();
        }
        $travel->device_id =request()->get('device_id');





        //BOX
        if($travel->box_id != request()->get('box_id')){
            // ACTUALIZAR CHOFER

            $box = Boxes::find(request()->get('box_id'));
            $box->status=0;
            $box->save();
        }
        $travel->box_id =request()->get('box_id');

        $new_route = Routes::find(request()->get('route_id'));
        //dd($travel->device_id);
        */



        


        
    }
    public function detectGeofence($originGeofence,$packet,$in){
        $buffer ='';
        if($originGeofence->type == 'circle'){
            //REVISAR STATUS
          $geocerca_circle = json_decode($geocerca['data'],true);
          $distance = $this->getDistance($packet->lat,$packet->lng,$originGeofence->lat,$originGeofence->lng);
          
          $distance = $distance * 1000;
          if($distance<=$originGeofence->radius){ 
            //dentro
            $status = 1;
            }else{ 
                //FUERA
            $status = 0;
        }

        }else{
            $polygon = array();
            $points = json_decode($originGeofence->poly_data,true);
          foreach ($points as $key => $value) {
            //dd($value);
           /* $value = split(',', $value);
            $pointsF .= "'". $value[0].' '. $value[1] ."',";*/
            $pt = $value['lat'].' '. $value['lng']; 
            
            array_push($polygon, $pt);
          }
          $point = $packet->lat . " " . $packet->lng;
          $status =  $this->pointInPolygon($point, $polygon);

          
          if($status == 'inside'){
          
            if($buffer == ''){
                //dd('adentro y buffer nada');
               
                $signe = Signes::create([
                'packet_id' => $packet->id,
                'geofence_id' =>$originGeofence->id,
                'device_id' =>$packet->devices_id,
                'status' =>1
                ]);
                $buffer = 1;
            }
            if($buffer == 0){
                $signe = Signes::create([
                'packet_id' => $packet->id,
                'geofence_id' =>$originGeofence->id,
                'device_id' =>$packet->devices_id,
                'status' =>1
                ]);
                $buffer = 1;
            }
            

            
          }
          if($status == 'outside'){
             
            if($buffer == 1){
               $signe = Signes::create([
                'packet_id' => $packet->id,
                'geofence_id' =>$originGeofence->id,
                'device_id' =>$packet->devices_id,
                'status' =>0
                ]); 
               $buffer = 0;
            }
            

            
          }
        }
        return $originGeofence->name;
    }

    public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
    $earth_radius = 6371;

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);

    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return $d;

}

    public function cancel(){

        $travel_id = request()->get('id');
        $travel = Travels::find($travel_id);
        $travel->tstate_id=7;

        $device = Devices::find($travel->device_id);
        $device->status = 0;
        $device->travel_id=null;
        $device->boxs_id=null;
        $device->tcode_id=null;
        $device->save();
        //ACUATULIZAR CAJA 1
        if($travel->box_id != null){
            $box = Devices::find($travel->box_id);
            $box->status = 0;
            $box->travel_id=null;
            $box->boxs_id=null;
            $box->save();
        }

        //ACTUALIZAR CHOFER
        $driver = Drivers::find($travel->driver_id);
        $driver->status=0;
        $driver->save();

        //ACTUALIZAR CAJA 2
        if($travel->additionalbox_id != null){
            $additionalbox = Devices::find($travel->additionalbox_id);
            $additionalbox->status = 0;
            $additionalbox->travel_id=null;
            $additionalbox->boxs_id=null;
            $additionalbox->save();
        }


        $motivo = request()->get('motivo');

        $comment = Comments::create([
            'comment' => $motivo,
            'user_id' =>Auth::user()->id,
            'travel_id' =>$travel->id,
            'tcode_id' =>$travel->tcode_id
        ]);

        $travel->save(); 

        return response()->json('cancelado');
    }
    public function newtravel()
    {
        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                    ->where('status',0)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $devices = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',1)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $boxes = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',2)
                    ->where('devices.status',0)
                    ->orderBy('created_at', 'asc')
                    ->get();

        $subclients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        return view('travels.new',compact('subclients','drivers','boxes','devices'));
    }
    public function add()
    {
        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $routes = Routes::where('routes.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $devices = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $subclients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        return view('travels.add',compact('devices','drivers','routes','subclients'));
    }
    public function authedit($id)
    {

        $travel = Travels::find($id);
        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                    ->where('status',0)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $devices = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',1)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $boxes = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',2)
                    ->where('devices.status',0)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $subclients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $location = Locations::find( $travel->location_id);
        $locations = Locations::where('locations.subclients_id',$travel->subclient_id)->get();
        $routes = Routes::where('routes.client_id',Auth::user()->client_id)
                    ->where('destination_id',$location->geofences_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $arrival = explode(' ' , $travel->arrival_date);
        $arrival_year = $arrival[0];
        $arrival_hour = $arrival[1];

        return view('travels.authedit',compact('devices','drivers','routes','subclients','travel','location','locations','arrival_year','arrival_hour','boxes'));
    }
    public function auth($id)
    {

        $travel = Travels::find($id);
        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                    ->where('status',0)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $devices = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',1)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $boxes = Devices::where('devices.client_id',Auth::user()->client_id)
                    ->where('devices.type_id',2)
                    ->where('devices.status',0)
                    ->orderBy('created_at', 'asc')
                    ->get();
        $subclients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();

        $location = Locations::find( $travel->location_id);
        $locations = Locations::where('locations.subclients_id',$travel->subclient_id)->get();


        /*$toclient = Toclients::find( $travel->toclient_id);
        $toclients = Toclients::where('subclients_id',$travel->subclient_id)->get();



        $routes = Routes::where('routes.client_id',Auth::user()->client_id)
                    ->where('destination_id',$toclient->geofences_id)
                    ->orderBy('created_at', 'asc')
                    ->get();*/  
 
        $routes = Routes::where('routes.client_id',Auth::user()->client_id)
                    ->where('destination_id',$travel->location->geofences->id)
                    ->orderBy('created_at', 'asc')
                    ->get();

        $arrival = explode(' ' , $travel->arrival_date);
        $arrival_year = $arrival[0];
        $arrival_hour = $arrival[1];

        $references = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->where('gcat_id',4)
                ->orderBy('created_at', 'asc')
                ->get();
        $geofences = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->where('gcat_id',1)
                ->orWhere('gcat_id',2) 
                ->orderBy('created_at', 'asc')
                ->get();

        return view('travels.auth',compact('devices','drivers','routes','subclients','travel','location','locations','arrival_year','arrival_hour','boxes','references','geofences'));
    }
    public function notification_read(){
        $id = request()->get('id');
        $notification = Notifications::find($id);
        $notification->read=1;
        $notification->save();
        return response()->json('cancelado');
    }
    public function create()
    {
        $this->validate(request(),[
            'name' => ['required'],
            'client_id' => ['required'],
            'init' => ['required'],
            'end' => ['required'],
            'driver_id' => ['required'],
            'device_id' => ['required'],
            'subclient_id' => ['required'],
            'route_id' => ['required']
        ]);
        $name = request()->get('name');
        $client_id = request()->get('client_id');
        $departure_date = request()->get('init') . ' '.request()->get('hour_init');
        $arrival_date = request()->get('end') . ' '.request()->get('hour_end');
        $driver_id = request()->get('driver_id');
        $device_id = request()->get('device_id');
        $subclient_id = request()->get('subclient_id');
        $route_id = request()->get('route_id');
        $salida = new Carbon($departure_date, 'America/Monterrey');
        $llegada = new Carbon($arrival_date, 'America/Monterrey');
        $now = Carbon::now('America/Monterrey');
        if($salida->lt($now)){
            if($llegada->lt($now)){
                Session::flash('message', "El rango de horas seleccionado no es válido");
                return Redirect::back();
            }
        }
        $route = Devices::find($device_id);
        $route->route_id=$route_id;
        $route->save();
/*
        $driver = Routes::find($driver_id);
        $driver->driver_id=$driver_id;
        $driver->save();
        $subclient = Routes::find($subclient_id);
        $subclient->subclient_id=$subclient_id;
        $subclient->save();
*/
        $device = Devices::find($device_id);
        $tstate_id = $this->getTravelStatus($salida,$llegada,$device->id,$device);
        $travel = Travels::create([
            'name' => $name,
            'client_id' =>$client_id,
            'subclient_id' =>$subclient_id,
            'route_id' =>$route_id,
            'driver_id' =>$driver_id,
            'device_id' =>$device_id,
            'departure_date'=>$departure_date,
            'arrival_date'=>$arrival_date,
            'tstate_id' =>$tstate_id
        ]);
        $travel_id = Devices::find($device_id);
        $travel_id->travel_id=$travel->id;
        $travel_id->save();
        $device = Devices::find($device_id);
        $device->status = 1;
        $device->save();
        flash('Viaje '.request()->get('name').' creado!');
        return redirect()->to('/travels');
    }
    public function authsave()
    {  

        $this->validate(request(),[
            'client_id' => ['required'],
            'init' => ['required'],
            'end' => ['required'],
            'driver_id' => ['required'],
            'device_id' => ['required'],
            'origin_id' => ['required'],
            'location_id' => ['required'],
            'subclient_id' => ['required']
        ]);
        $departure_date = request()->get('init');
        $arrival_date = request()->get('end');
        $salida = new Carbon($departure_date, 'America/Monterrey');
        $llegada = new Carbon($arrival_date, 'America/Monterrey');
        $now = Carbon::now('America/Monterrey');
        if($salida->lt($now)){
            if($llegada->lt($now)){
                Session::flash('message', "El rango de horas seleccionado no es válido");
                return Redirect::back();
            }
        }

         // DETERMINAR GEO REFERENCIAS
        $ref=1;
        $references = array();
        foreach (request()->all() as $key => $value) {
            if($key == 'route-ref-id-'.$ref){
                $ide = request()->get('estimated-hour-'.$ref);
                $reference = array($value => $ide);
                array_push($references,$reference);
                $ref++;
            }

        }

        $client_id = request()->get('client_id');
        $origin_id = request()->get('origin_id');
        $location_id = request()->get('location_id');

        $origin_location = Locations::find($origin_id);
        $origin = Geofences::find($origin_location->geofences_id);
          
        $location = Locations::find($location_id);
        $destination = Geofences::find($location->geofences_id);
        $name = $origin->name . " - " . $destination->name;
        if(request()->get('route_id')!='Selecciona una ruta'){
            
            $route =  Routes::find(request()->get('route_id'));
        }else{
            $route =  Routes::create([
                    'name' => $name,
                    'client_id' =>$client_id,
                    'origin_id' => $origin->id,
                    'destination_id' => $destination->id,
                    'references_route'=>json_encode($references)
                ]);
        }



        $travel_id = request()->get('travel_id');
        $travel= Travels::find($travel_id);
        $travel->name = request()->get('name');
        $travel->client_id = request()->get('client_id');
        $box_id = request()->get('box_id');

        
        if(request()->get('additionalbox_id')==null){
            $travel->additionalbox_id = null;
        }else{
            $travel->additionalbox_id = request()->get('additionalbox_id');
            $additionalbox_id = Devices::find(request()->get('additionalbox_id'));
            $additionalbox_id->status=1;
            $additionalbox_id->new=0;
            $additionalbox_id->save();
        }
        $travel->location_id = request()->get('location_id');
        
        $travel->departure_date = request()->get('init');
        $travel->arrival_date = request()->get('end');
        $travel->driver_id = request()->get('driver_id');
        $travel->device_id = request()->get('device_id');
        $device_id = request()->get('device_id');
        $travel->subclient_id = request()->get('subclient_id');
        
        $travel->route_id = $route->id;
        
        //$route = Devices::find($device_id);
        //$route->route_id=$route_id;
       // $route->save();
/*
        $driver = Routes::find($driver_id);
        $driver->driver_id=$driver_id;
        $driver->save();
        $subclient = Routes::find($subclient_id);
        $subclient->subclient_id=$subclient_id;
        $subclient->save();
*/
        $device = Devices::find($device_id);
        //$travel->tstate_id = $this->getTravelStatus($salida,$llegada,$device->id,$device);

        $travel->tstate_id = $this->getTravelStatusByGeofence($salida,$llegada,$device,$route->id);

        $travel->save();
        $update_travel_id = Devices::find($device_id);
        $update_travel_id->travel_id=$travel->id;
        $update_travel_id->save();

        // CAJA VACIA
        if($box_id != ''){
            $travel->box_id = $box_id;
            $box = Devices::find($box_id);
            $box->status=1;
            $box->new=0;
            $box->travel_id=$travel_id;
            $box->boxs_id=$device_id;
            $box->save();
        }else{
            $travel->box_id = null;
        }
        

        $device = Devices::find($device_id);
        $device->status = 1;
        if($box_id != ''){
            $device->boxs_id = $box_id;
        }
        
        $device->tcode_id = request()->get('tcode_id');
        $device->save();

        //ACTUALIZAR CHOFER

        $driver = Drivers::find(request()->get('driver_id'));
        $driver->status=1;
        $driver->save();

        // GUARDAR NOTIFICACION



        //ACTUALIZAR READ USUARIO
        $users = User::where('id','!=',Auth::user()->id)->where('client_id',Auth::user()->client_id)->get();
        foreach($users as $user){
            $user->read=1;
            $new_notification = $user->new_notifications + 1;
            $user->new_notifications = $new_notification;
            $user->save();

            $notification = Notifications::create([
                'client_id' =>Auth::user()->client_id,
                'nde_id'=>1,
                'user_id'=>$user->id,
                'author_id'=>Auth::user()->id,
                'tcode_id'=>request()->get('tcode_id'),
                'link'=> '/travel/'.request()->get('tcode_id')
            ]);
        }

        flash('Viaje '.request()->get('name').' creado!');
        return redirect()->to('/travels')->with('travel', Auth::user()->id);
        //return view('travels.confirmation',compact('travel'));
    }
    public function autheditsave()
    {   
        $travel_id = request()->get('travel_id');
        $travel= Travels::find($travel_id);
        
        $this->validate(request(),[
            'user_id' => ['required'],
            'end' => ['required'],
            'subclient_id' => ['required']
        ]);
        $name = request()->get('name');
        $user_id = request()->get('user_id');

        $subclient_id = request()->get('subclient_id');
        $arrival_date = request()->get('end');
        $location_id = request()->get('location_id');
        $boxs_number = request()->get('boxs_number');
        $tcode_id = request()->get('tcode_id');
        $postage = request()->get('postage');
        $departure_date = request()->get('init');
        if(request()->get('reference') != ''){
            $r = request()->get('reference');
            $r = substr_replace($r, "", -1);

            $r = explode(',',$r);

            $r = json_encode($r);
        }else{
            $r=request()->get('reference_old');
        }    
        $salida = new Carbon($departure_date, 'America/Monterrey');
        $llegada = new Carbon($arrival_date, 'America/Monterrey');
        $now = Carbon::now('America/Monterrey');
        if($salida->lt($now)){
            if($llegada->lt($now)){
                Session::flash('message', "El rango de horas seleccionado no es válido");
               
                return Redirect::back();
            }
        }
        $device_id = request()->get('device_id');
        $box_id = request()->get('box_id');
        $driver_id = request()->get('driver_id');
        
        if($device_id == ''){
            $device_id = null;

        }
        if($box_id == ''){
            $box_id = null;

        }
        if($driver_id == ''){
            $driver_id = null;
        }
        $tstate_id = 5;
        $travel->tstate_id=5;

        $travel->device_id=$device_id;
        $travel->box_id=$box_id;
        $travel->driver_id=$driver_id;

        $travel->user_id=$user_id; 
        $travel->boxs_number=$boxs_number;
        $travel->subclient_id=$subclient_id;
        $travel->departure_date=$departure_date;
        $travel->arrival_date=$arrival_date;
        $travel->active=1;
        $travel->location_id=$location_id;
        $travel->tcode_id=$tcode_id;
        $travel->reference=$r;
        $travel->postage=$postage; 
        $travel->save();
        flash('Viaje '.request()->get('name').' creado!');
        return redirect()->to('/orders');
        
         
    }
    public function create_order()
    {

        $r = request()->get('reference');
        $r = substr_replace($r, "", -1);

        $r = explode(',',$r);

        $r = json_encode($r);

        $this->validate(request(),[
            'client_id' => ['required'],
            'end' => ['required'],
            'subclient_id' => ['required']
        ]);
        $name = request()->get('name');
        $client_id = request()->get('client_id');
        $subclient_id = request()->get('subclient_id');
        $arrival_date = request()->get('end');
        $location_id = request()->get('location_id');
        $toclient_id = request()->get('toclient_id');
        $boxs_number = request()->get('boxs_number');
        
        $device_id = request()->get('device_id');
        $box_id = request()->get('box_id');
        $driver_id = request()->get('driver_id');
        
        if($device_id == ''){
            $device_id = null;

        }
        if($box_id == ''){
            $box_id = null;

        }
        if($driver_id == ''){
            $driver_id = null;
        }

        $postage = request()->get('postage');
        $tcode = Tcodes::create([
            'tcode' =>time(),
            'client_id' =>$client_id
        ]);
        // CREAR Y ACTUALIZAR EL CODE_NAME
        $tcode_u = Tcodes::find($tcode->id);
        $tcode_u->code = $tcode->id . '-t';
        $tcode_u->save();
        if(empty(request()->get('init'))){
            $tstate_id = 5;
            $travel = Travels::create([
                'name' => $name,
                'client_id' =>$client_id,
                'subclient_id' =>$subclient_id,
                'arrival_date'=>$arrival_date,
                'tstate_id' =>$tstate_id,
                'location_id'=>$location_id,
                'toclient_id'=>$toclient_id,
                'boxs_number'=>$boxs_number,
                'box_id'=>$box_id,
                'driver_id'=>$driver_id,
                'route_id'=>null,
                'reference'=>$r,
                'device_id'=>$device_id,
                'tcode_id'=>$tcode->id,
                'active'=>1,
                'user_id'=>Auth::user()->id,
                'postage'=>$postage
            ]);
            flash('Viaje '.request()->get('name').' creado!');
            return redirect()->to('/orders');
        }
        $departure_date = request()->get('init');
        $route_id = request()->get('route_id');
        $salida = new Carbon($departure_date, 'America/Monterrey');
        $llegada = new Carbon($arrival_date, 'America/Monterrey');
        $now = Carbon::now('America/Monterrey');
        if($salida->lt($now)){
            if($llegada->lt($now)){
                Session::flash('message', "El rango de horas seleccionado no es válido");
                return Redirect::back();
            }
        }
        $tstate_id = 5;
        $travel = Travels::create([
            'name' => $name,
            'client_id' =>$client_id,
            'subclient_id' =>$subclient_id,
            'departure_date'=>$departure_date,
            'arrival_date'=>$arrival_date,
            'tstate_id' =>$tstate_id,
            'location_id'=>$location_id,
            'toclient_id'=>$toclient_id,
            'boxs_number'=>$boxs_number,
            'driver_id'=>$driver_id,
            'box_id'=>$box_id,
            'route_id'=>null,
            'device_id'=>$device_id,
            'reference'=>$r,
            'tcode_id'=>$tcode->id,
            'active'=>1,
            'user_id'=>Auth::user()->id,
            'postage'=>$postage
        ]);
        flash('Viaje '.request()->get('name').' creado!');
        return redirect()->to('/orders');
    }
    public function read($id)
    {
        //$travel = Travels::find($id);
        $travel = Travels::where('tcode_id',$id)->orderBy('created_at','desc')->first();


        $geofences = Signes::where('device_id',$travel->device_id)->whereBetween('updateTime',[$travel->departure_date,$travel->arrival_date])->get();
        // si la fecha de salida es despues de cuando salio, no sale el tiempo de carga
        
        $destination = $travel->route->destination_id;
        $origin = $travel->route->origin_id;

        $real_departure = 0;
        $real_arrival = 'No disponible';
        $origin_arrival_time = 'No disponible';
        $destination_arrival_time = 'No disponible';
        $descarga = 'No disponible';
        $carga = 'No disponible';

        $od_geofences = array();
        $origin_geofence = Geofences::find($travel->route->origin_id);
        $dest_geofence = Geofences::find($travel->route->destination_id);
        array_push($od_geofences,$origin_geofence);
        array_push($od_geofences,$dest_geofence);

        $origin_entrance = Signes::where('device_id',$travel->device_id)
        ->where('geofence_id',$origin)
        ->where('status',1)
        ->where('updateTime','<',$travel->arrival_date)
        ->orderBy('updateTime','desc')
        ->first(); 
        //2017-06-12 15:28:03
        //2017-06-16 06:59:14
        if(!empty($origin_entrance)){
            $origin_arrival_time = $origin_entrance->updateTime;
             
            //$geofences = Signes::where('device_id',$travel->device_id)->whereBetween('updateTime',[$origin_entrance->updateTime,$travel->arrival_date])->get();
            //DUDA **** SI SE TARDO MUCHO COMPARARLA CON NOW
            $to = Carbon::now('America/Monterrey');
            $geofences = Signes::where('device_id',$travel->device_id)->whereBetween('updateTime',[$origin_entrance->updateTime,$to])->get();
        } 
        foreach ($geofences as $geofence) {    
            if($geofence->geofence_id == $origin AND $geofence->status==0){
                 
                $real_departure = $geofence->packet->updateTime;

                $salida = new Carbon($real_departure, 'America/Monterrey');
                $llegada = new Carbon($origin_arrival_time, 'America/Monterrey');
                $carga = $salida->diffInMinutes($llegada);
                 if($carga > 60){
                  $hours = floor($carga / 60); // Get the number of whole hours
                  $minutes = $carga % 60; // Get the remainder of the hours
                  $mov = $hours . ":" .$minutes . " horas";
              }else{
                  $mov = $carga . " mins";
              }
                $carga = $mov;

            }
            if($geofence->geofence_id == $destination AND $geofence->status==1){
                $destination_arrival_time = $geofence->packet->updateTime;
             
            }
            if($geofence->geofence_id == $destination AND $geofence->status==0){
                $real_arrival = $geofence->packet->updateTime;
                
                $salida = new Carbon($destination_arrival_time, 'America/Monterrey');
                $llegada = new Carbon($real_arrival, 'America/Monterrey');
                $descarga = $salida->diffInMinutes($llegada);
                 if($descarga > 60){
                  $hours = floor($descarga / 60); // Get the number of whole hours
                  $minutes = $descarga % 60; // Get the remainder of the hours
                  $mov = $hours . ":" .$minutes . " horas";
              }else{
                  $mov = $descarga . " mins";
              }
                $descarga = $mov;
            }
        }

        if($real_arrival != 0 AND $real_departure != 0){
             $salida = new Carbon($real_departure, 'America/Monterrey');
             $llegada = new Carbon($destination_arrival_time, 'America/Monterrey');

             $total_travel = $salida->diffInMinutes($llegada);
             if($total_travel > 60){
              $hours = floor($total_travel / 60); // Get the number of whole hours
              $minutes = $total_travel % 60; // Get the remainder of the hours
              $mov = $hours . ":" .$minutes . " horas";
          }else{
              $mov = $total_travel . " mins";
          }
              $total_travel = $mov; 

        }else{
            $total_travel = 'No disponible';
        }

        //dd($real_departure,$real_arrival);
        
        if($travel->tstate_id==4){ 
            $packets = Packets::where('devices_id',$travel->device_id)->whereBetween('updateTime',[$travel->departure_date,$destination_arrival_time])->get();
             $report = $this->parseReport($packets,$travel->device->id,$travel->departure_date,$destination_arrival_time);
      
        }elseif($travel->tstate_id==2 OR $travel->tstate_id==3 OR $travel->tstate_id==5 OR $travel->tstate_id==8 OR $travel->tstate_id==7){
            if($origin_arrival_time != 'No disponible'){
               
                $packets = Packets::where('devices_id',$travel->device_id)->whereBetween('updateTime',[$origin_arrival_time,$travel->arrival_date])->get();
                $report = $this->parseReport($packets,$travel->device->id,$origin_arrival_time,$travel->arrival_date);
            }else{
                
                $packets = Packets::where('devices_id',$travel->device_id)->whereBetween('updateTime',[$travel->departure_date,$travel->arrival_date])->get();
                $report = $this->parseReport($packets,$travel->device->id,$travel->departure_date,$arrival_date);
            }
            
            
        }

        if($travel->tstate_id==9){ 
            $packets = Packets::where('devices_id',$travel->device_id)->whereBetween('updateTime',[$travel->departure_date,$destination_arrival_time])->get();
            $report = $this->parseReport($packets,$travel->device->id,$travel->departure_date,$destination_arrival_time);
        }

        if($travel->tstate_id==1){ 
            $packets = Packets::where('devices_id',$travel->device_id)->whereBetween('updateTime',[$travel->departure_date,$travel->arrival_date])->get();
            $report = $this->parseReport($packets,$travel->device->id,$travel->departure_date,$travel->arrival_date);
        }


$descarga_time ='x';
        if($travel->tstate_id==9){

            $salida = new Carbon($real_departure, 'America/Monterrey');
             $llegada = Carbon::now('America/Monterrey');
             $total_travel = $salida->diffInMinutes($llegada);
             if($total_travel > 60){
              $hours = floor($total_travel / 60); // Get the number of whole hours
              $minutes = $total_travel % 60; // Get the remainder of the hours
              $mov = $hours . ":" .$minutes . " horas";
          }else{
              $mov = $total_travel . " mins";
          }


          $salida_ = new Carbon($destination_arrival_time, 'America/Monterrey');
             $llegada_ = Carbon::now('America/Monterrey');
             $total_travel_ = $salida_->diffInMinutes($llegada_);
             if($total_travel_ > 60){
              $hours = floor($total_travel_ / 60); // Get the number of whole hours
              $minutes = $total_travel_ % 60; // Get the remainder of the hours
              $mov_ = $hours . ":" .$minutes . " horas";
          }else{
              $mov_ = $total_travel_ . " mins";
          }


              $descarga_time = $mov_; 

        }
        $comments = Comments::where('tcode_id',$travel->tcode_id)->get();

       
        
        $head = $report[0];
        $body = $report[1];
        $title = $report[2];

        $map_info  = $report[8];
        $points  = $report[4]; 
        $max  = $report[9]; 
        $stop_parse = $report[10];
            $bad_engine = $report[11];   
        return view('travels.read',compact('travel','descarga_time','comments','head','body','title','real_departure','real_arrival','map_info','points','total_travel','max','origin_arrival_time','destination_arrival_time','descarga','carga','od_geofences','stop_parse','bad_engine'));
    }
    public function history($id)
    {
        $travels = Travels::where('tcode_id',$id)->orderBy('created_at','asc')->get();
        return view('travels.history',compact('travels'));
    }

    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;

        // Transformar la cadena de coordenadas en matrices con valores "x" e "y"
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }

        // Checar si el punto se encuentra exactamente en un vértice
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }

        // Checar si el punto está adentro del poligono o en el borde
        $intersections = 0;
        $vertices_count = count($vertices);

        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Checar si el punto está en un segmento horizontal
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) { // Checar si el punto está en un segmento (otro que horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        // Si el número de intersecciones es impar, el punto está dentro del poligono.
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }

    }

    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

}
