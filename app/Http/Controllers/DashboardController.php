<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use App\Packets;
use App\Clients;
use App\Travels;
use Auth;
use DB; 
use Carbon\Carbon;
use Nexmo; 
class DashboardController extends Controller
{
    use DevicesTraits;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
         
        
 
/*
        $nexmo = app('Nexmo\Client');
$send = $nexmo->message()->send([
    'to' => '8124152699',
    'from' => 'NEXMO',
    'text' => 'Using the instance to send a message.'
]);
dd($send);
*/
        $user = User::find(Auth::user()->id);
        $packets = Packets::count();
        $users = User::count();
        $devices  = Devices::count();
        $clients = Clients::count();
        $travels = Travels::count();
        $travelsOnRoad = Travels::where('tstate_id', '=', 2)->count();
        $platformState = DB::table('packets')->orderBy('id', 'desc')->first();

        if($platformState != null){
            $lastReportPacket = new Carbon($platformState->updateTime, 'America/Monterrey');
        }else{
            $lastReportPacket = new Carbon('2012-12-12 12:12:12');
        }


        $now = Carbon::now('America/Monterrey');
        $timeforhumans = $now->diffForHumans($lastReportPacket);
        $timeforComputer = $now->diffInMinutes($lastReportPacket);



        if($timeforComputer > 30){
            $relax = 0;
        }else{
            $relax =1;
        }

        return view('admin.home', compact('user','devices','packets','users','devices','clients','travels','travelsOnRoad','relax','timeforhumans'));
    }

}
