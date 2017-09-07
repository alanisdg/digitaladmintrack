<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use App\Packets;
use App\Configs;
use App\Packets_live;
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
        $user = User::find(Auth::user()->id);
        $devices = $user->getDevices($user);
        $alldevices = $user->getAllDevices($user);
        $boxes = $user->getBoxes($user);
        $config = Configs::where('client_id',$user->client_id)->first();
        $devices_availables =0;

        return view('home', compact('user','devices','devices_availables','config','boxes','alldevices'));
    }

    public function mapa()
    {
        return view('mapa');
    }
}
