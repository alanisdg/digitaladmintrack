<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use App\Packets;
use App\Configs;
use App\Packets_live;
use App\Clients;
use App\Travels;
use View;
use Auth;
use DB;
use Carbon\Carbon;

class HomeController extends BaseController
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
        parent::__construct();
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {

    	        $user = Auth::user()->id;
        //$devices = $user->getDevices($user);


        $alldevices = Auth::user()->getAllDevices(Auth::user());
        $devices = array();
        $boxes= array();
foreach ($alldevices as $device) {
    if($device->type_id == 1){
        array_push($devices, $device);
    }
    if($device->type_id == 2){
        array_push($boxes, $device);
    }
} 

 

        // $boxes = $user->getBoxes($user);
        $config = Configs::where('client_id',Auth::user()->client_id)->first();
        $devices_availables =0;  
       
        return view('home', compact('user','devices','devices_availables','config','boxes','alldevices'));


/*
            $client_id = Auth::user()->client_id;
        $client = Clients::find($client_id);
        
        $devices = Auth::user()->getDevices(Auth::user(),$client);

        //$alldevices = Auth::user()->getAllDevices(Auth::user());
        $boxes = Auth::user()->getBoxes(Auth::user(),$client);
        //dd($boxes);
        //$tdfw = array_merge($boxes, $devices);
        $alldevices = $boxes->merge($devices);
        //dd($devices,$alldevices,$boxes,$merged);
        
        
        $config = Configs::where('client_id',Auth::user()->client_id)->first();
        $devices_availables =0;
        //return view('test', compact('user','devices','devices_availables','config','boxes','alldevices'));
        return view('home', compact('user','devices','devices_availables','config','boxes','alldevices'));
        */
    }


        public function home2()
    {

        $user = Auth::user()->id;
        //$devices = $user->getDevices($user);


        $response = Auth::user()->getAllDevicesTest(Auth::user());
        $alldevices  = $response[1];
        $groups = $response[0];
        $groups_cajas = $response[2];
        $devices = array();
        $boxes= array();
        foreach ($alldevices as $device) {
           
            if($device->type_id == 1){
                array_push($devices, $device);
            }
            if($device->type_id == 2){
                array_push($boxes, $device);
            }
        }


 

        // $boxes = $user->getBoxes($user);
        $config = Configs::where('client_id',Auth::user()->client_id)->first();
        $devices_availables =0;  
         
        if(Auth::user()->role_id == 7){ 
            //dd('es guardia');
            return redirect()->to('/guardia');
        }
        return view('home2', compact('user','devices','devices_availables','config','boxes','alldevices','groups','groups_cajas'));

    }



    public function mapa()
    {
        return view('mapa');
    }
}
