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


class CronController extends Controller
{


    

    public function clean(){
      dd('clean');
        $ayer = Carbon::yesterday();
         $user = User::find(1);
         $user->name = 'Horacio Cron 4';
            $user->save();
            
        DB::table('packets_lives')->where('updateTime', '<', $ayer)->delete();

    }

  

}