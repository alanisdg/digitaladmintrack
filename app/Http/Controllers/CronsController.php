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


//use Mail;

use App\Http\Controllers\Controller;



use DB;
/**
 *
 */
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\User;
use App\Clients;
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

    public function payment_alert(){
        $clients = Clients::all();
        $users = User::all();
        foreach($clients as $client){
            $alert_client_day = $client->charge_at;
            $day_before = $alert_client_day - 1;
            $today = date('d');
            if($day_before == $today){
                //dd('enviar alerta al cobrador');
                foreach ($users as $user) {
                    if($user->role_id == 1){
                        $mailer = app()['mailer'];
                        $mailer->send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
            });
                        dd($mailer);
                        
                        dd('envair a ' . $user->email . ' mañana se cobra a ' . $client->name );
                    }
                }
            }
        }
    }

  

}