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
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\User;
use DB;
class CronsController extends Controller
{


    

    public function clean(){
       $ayer = Carbon::yesterday();
        /* $user = User::find(1);
         $user->name = 'Horacio Cron 6';
            $user->save();
            */
        /*$user = User::find(1);
        $user->name = 'h7';
        $user->save();*/
        DB::table('packets_lives')->where('updateTime', '<', $ayer)->delete();

    }

  

}