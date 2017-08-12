<?php

namespace App\Http\Controllers;
use App\Geofences;
use App\User;
use App\Travels;
use App\Packets;
use App\Packets_live;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class ToolsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function index()
    {
        $user = User::find(Auth::user()->id);
        $packet = Packets_live::find(1);
        $devices = $user->getDevices($user);



        foreach ($devices as $device) {

            if($device->tcode_id != null){
                $travel = Travels::where('tcode_id',$device->tcode->id)->orderBy('created_at','desc')->first();

                $salida = new Carbon($travel->departure_date, 'America/Monterrey');
                $llegada = new Carbon($travel->arrival_date, 'America/Monterrey');
                $now = Carbon::now('America/Monterrey');
            }

        }
        $devices = $user->getDevices($user);

        $geofences = Geofences::where('geofences.id_client',Auth::user()->client_id)
                ->orderBy('created_at', 'asc')
                ->get();

        return view('tools',compact('geofences','devices'));
    }
}
