<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geofences;
use App\Drivers;
use App\Routes;
use Auth;

class RoutesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function index()
    {
        $routes = Routes::where('routes.client_id',Auth::user()->client_id)
                ->orderBy('created_at', 'asc')
                ->get();

        return view('routes.index',compact('routes','drivers'));
    }

    public function get()
    {
        $id = request()->get('id');

        $routes = Routes::where('destination_id',$id)->get();

        return response()->json( $routes);
    }

    public function getPosibleRoutes()
    {
        $origin_id = request()->get('origin_id');
        $destination_id = request()->get('destination_id');

        


        $routes = Routes::where('destination_id',$destination_id)
        ->where('origin_id',$origin_id)->get();
        $name='';
        foreach ($routes as $route) {
             $references = json_decode($route->references_route,true);

             foreach ($references as $key => $value) {
                 foreach ($value as $k => $v) {
                     //dd($k);

                     $geofence = Geofences::find($k);
                     $name .= $geofence->name . ",";
                 }
             }
             $name = rtrim($name, ',');
             $route->references_name = $name;
             $name='';
        }
        
        
        return response()->json( $routes);
    }

    public function getdest()
    {
        $id = request()->get('id');

        $routes = Routes::where('destination_id',$id)->get();
 
        //return response()->json( $routes);
        return response()->json([
            'routes'=>$routes,
            'origin'=>'origin',
            ]);

         
    }

    public function edit()
    {

        $client_id = request()->get('client_id');
        $origin_id = request()->get('origin_id');
        $destination_id = request()->get('destination_id');

        $origin = Geofences::find($origin_id);
        $destination = Geofences::find($destination_id);

        $name = $origin->name . " - " . $destination->name;


        $route = Routes::find(request()->get('route_id'));
        $route->destination_id = $destination_id;
        $route->origin_id = $origin_id;
        $route->name = $name;
        $route->save();
        return redirect('/routes');
    }

    public function add()
    {

        $geofences = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->where('gcat_id',1)
                ->orWhere('gcat_id',2) 
                ->orderBy('created_at', 'asc')
                ->get();


                $references = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->where('gcat_id',4)
                ->orderBy('created_at', 'asc')
                ->get();

        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
        return view('routes.add',compact('geofences','drivers','references'));
    }

    public function read($id)
    {
        $geofences = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->orderBy('created_at', 'asc')
                ->get();
        $route = Routes::find($id);
        return view('routes.read',compact('route','geofences'));
    }

    public function create()
    {
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

        $name = request()->get('name');
        $client_id = request()->get('client_id');
        $origin_id = request()->get('origin_id');
        $destination_id = request()->get('destination_id');

        $origin = Geofences::find($origin_id);
        $destination = Geofences::find($destination_id);

        $name = $origin->name . " - " . $destination->name;

        Routes::create([
            'name' => $name,
            'client_id' =>$client_id,
            'origin_id' => $origin_id,
            'destination_id' => $destination_id,
            'references_route'=>json_encode($references)
        ]);

        return redirect('/routes');
    }
}
