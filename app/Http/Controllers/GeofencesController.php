<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geofences;
use App\Locations;
use App\Toclients;
use App\Travels;
use App\Devices;
use App\User;
use Auth;

//INCLUIR pasat
//use Illuminate\Support\Facades\Request;

class GeofencesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    // METODO 1
    public function saveLocation($client_id,$geofence_id,$name,$direction,$phone,$phone2,$email){
        $data['subclients_id']=$client_id;
        $data['geofences_id']=$geofence_id;
        $data['name']=$name;
        $data['direction']=$direction;
        $data['phone']=$phone;
        $data['phone_2']=$phone2;
        $data['email']=$email;
        $location = Locations::create($data);
        return $location;
    }
    
    public function saveClient($client_id,$geofence_id,$name,$direction,$phone,$phone2,$email){
        $data['subclients_id']=$client_id;
        $data['geofences_id']=$geofence_id;
        $data['name']=$name;
        $data['direction']=$direction;
        $data['phone']=$phone;
        $data['phone_2']=$phone2;
        $data['email']=$email;
        $location = Toclients::create($data);
        return $location;
    }
    public function delete($id)
    {
         
        $geofence = Geofences::find($id);
        $geofence->delete();
        return redirect('geofences');
    }

    public function get()
    {
        $id = request()->get('id');
        $geofence = Geofences::find($id);
        return response()->json($geofence);
    }

    public function getReferences()
    {
        $state_id = request()->get('id');
        $references = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->where('state_id',$state_id)
                ->where('gcat_id',4)
                ->orWhere('gcat_id',5) 
                ->orderBy('created_at', 'asc')
                ->get();
        return response()->json($references);
    }


    public function store()
    {
         
    //dd(request()->all());
        // request()->get('lat') solo un campo
        // request()->only(['lat','lng'] varios campos
        if(request()->get('type')==''){
            return redirect('tools')->with('geofence', 'nada');
        }


        if( !empty(request()->get('subclient_id'))) {
                // SI ES LOCACION PONERLE NOMBRE GENERICO

                $data['name']=request()->get('location_name');
            }else{
                $data['name']=request()->get('name');
            }

        if(request()->get('type')=='poly'){

            $data['id_client']=request()->get('id_client');
            $data['poly_data']=request()->get('poly_data');
            $data['color']=request()->get('color');
            $data['type']=request()->get('type');
            $data['city']=request()->get('city');
            $data['state_id']=request()->get('state_id');

            $data['subclient_id'] = request()->get('subclient_id');
            $data['location_name']= request()->get('location_name');
            $data['direction']= request()->get('direction');
            $data['phone']= request()->get('phone');
            $data['phone_2']= request()->get('phone_2');
            $data['email']= request()->get('email');


            $category = explode("|", request()->get('gcat_id'));
            $data['gcat_id']=$category[0];

            $geofence = Geofences::create($data);

            if(!empty(request()->get('clienttoclient'))){
                $save = $this->saveClient($data['subclient_id'],$geofence->id,$data['location_name'],$data['direction'],$data['phone'],$data['phone_2'],$data['email']);
                flash('Geocerca '.request()->get('name').' creada!');
                return redirect()->to('clients');
                dd('no');
            }


            if( !empty(request()->get('subclient_id')) ){


                $save = $this->saveLocation(request()->get('subclient_id'),$geofence->id,request()->get('location_name'),request()->get('direction'),request()->get('phone'),request()->get('phone_2'),request()->get('email'));
                flash('Geocerca '.request()->get('name').' creada!');
                return redirect()->to('clients');
            }else{
                flash('Geocerca '.request()->get('name').' creada!');
                return redirect()->to('tools');
            }
        }else{
            //$data = request()->all();

            $category = explode("|", request()->get('gcat_id'));
            $data['gcat_id']=$category[0];
            $data['type']=request()->get('type');
            $data['city']=request()->get('city');
            $data['radius']=request()->get('radius');
            $data['lat']=request()->get('lat');
            $data['lng']=request()->get('lng');
            $data['state_id']=request()->get('state_id');
            $data['id_client']=request()->get('id_client');
            $data['color']=request()->get('color');
            $data['subclient_id'] = request()->get('subclient_id');
            $data['location_name']= request()->get('location_name');
            $data['direction']= request()->get('direction');
            $data['phone']= request()->get('phone');
            $data['phone_2']= request()->get('phone_2');
            $data['email']= request()->get('email');

            $geofence = Geofences::create($data);

            if(!empty(request()->get('clienttoclient'))){
                $save = $this->saveClient($data['subclient_id'],$geofence->id,$data['location_name'],$data['direction'],$data['phone'],$data['phone_2'],$data['email']);
                flash('Geocerca '.request()->get('name').' creada!');
                return redirect()->to('clients');
                dd('no');
            }
            if(!empty($data['subclient_id'])){
                $save = $this->saveLocation($data['subclient_id'],$geofence->id,$data['location_name'],$data['direction'],$data['phone'],$data['phone_2'],$data['email']);
                flash('Geocerca '.request()->get('name').' creada!');
                return redirect()->to('clients');
            }else{
                flash('Geocerca '.request()->get('name').' creada!');
                return redirect()->to('tools');
            }

        }


    }
    public function geofences(){
        $user = User::find(Auth::user()->id);
        $devices = $user->getDevices($user);



        foreach ($devices as $device) {

            if($device->tcode_id != null){
                $travel = Travels::where('tcode_id',$device->tcode->id)->orderBy('created_at','desc')->first();

            }

        }
        $devices = $user->getDevices($user);

        $geofences = Geofences::where('geofences.id_client',Auth::user()->client_id)
        ->where('gcat_id','!=',1)
                ->orderBy('created_at', 'asc')
                ->get();   
        return view('geofences.geofences',compact('geofences','devices'));
    }

    public function get_all(){
        $geofences = Geofences::where('id_client',Auth::user()->client_id)
        ->where('deleted_at',null)
        ->get();

        return response()->json([
            'geofences' =>$geofences,
        ]);
    }
    /*

    // METODO 2
    public function store(Request $request){
        dd($request->only(['lat','radius']));
    }

    // METODO 3 usar pasat se incluye el pasat
    public function store(){
        dd(Request::only(['lat','radius']));
    }
    */
}
