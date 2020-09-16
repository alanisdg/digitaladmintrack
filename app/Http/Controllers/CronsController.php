<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Devices;
use App\Clients;
use App\Packets;
use App\Routes;
use App\Geofences;
use App\User;
use Mail;
use Carbon\Carbon;
use Auth;
use App\Mail\PaymentAlerts;
use App\Mail\SendContact;
use App\Mail\SendContactLanding;
use App\Mail\SameDay;
use App\Mail\SuspensionDay;
use App\Mail\DayBeforeSuspension;
//use Mail;

use App\Http\Controllers\Controller;



use DB;
/**
 *
 */ 
   
 
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

    public function saveInvoice(){
        $clients = Clients::all();
        foreach($clients as $client){
            $client_pay_day = $client->charge_at;
            if(date('d') == $client_pay_day){
                
                $invoice = app('App\Http\Controllers\ClientsController')->publicInvoice($client->id);
                
            }
        }
    }

    public function sendMail(){
       
        $nombre  = request()->get('nombre');
        $compania  = request()->get('compania');
        $telefono = request()->get('telefono');
        $comentarios  = request()->get('comentarios');
 
        $mail = 'alanisdg@gmail.com';
        $m = Mail::to($mail)->send(new SendContact($nombre,$compania,$telefono,$comentarios));

        return response()->json([ 
            'send'=>$m
        ]);
    }

    public function sendLanding(){

        $name  = request()->get('name');
        $correo  = request()->get('correo');
        $ciudad = request()->get('ciudad');
        $empresa  = request()->get('empresa');
        $unidades  = request()->get('unidades');
        $comentarios  = request()->get('comentarios');
 
       // $mail = 'nestor.sandoval@digitaladmintrack.com';
       $mail = 'alanisdg@gmail.com';
        $m = Mail::to($mail)->send(new SendContactLanding($name,$correo,$ciudad,$empresa,$unidades,$comentarios));

        return response()->json([ 
            'send'=>$m
        ]);
    }


    public function payment_alert(){
        $clients = Clients::all();
        $users = User::all();

        foreach($clients as $client){

            $lastPayment = $client->payment;
            $payment = new Carbon($lastPayment);
             
            $monthPay = $payment->format('m');

            $month = date('d');
 

            if($month != $monthPay){
                $invoice = app('App\Http\Controllers\ClientsController')->generateInvoice($client->id);
                $genereteDay = Carbon::create(date('y'),  date('m'), $client->charge_at, 0);
            $SuspensonDay = $genereteDay->addDays(10)->day;
             
             $dt = Carbon::now();
            $today = $dt->day;
                if($SuspensonDay == $today){
                    // PONER CONDICION DE QUE SI YA PAGARON NO CORTE EL SERVICIO
                    //$client->access = 1;
                    $client->save();
                }
                $client->adeudo = $invoice['total'];
                    $alert_client_day = $client->charge_at;

            
            
            
            

            $alert_client_day = Carbon::create(date('y'),  date('m'), $client->charge_at, 0);
            $alert_client_day = $alert_client_day->day;

            $day_before_gen = Carbon::create(date('y'),  date('m'), $client->charge_at, 0);
            $day_before = $day_before_gen->subDay(1)->day;

            $genereteDay_ = Carbon::create(date('y'),  date('m'), $client->charge_at, 0);
            $dayAfterSuspenson = $genereteDay_->addDays(9)->day;

            
            
            // UN DIA ANTES
            if($day_before == $today){
                 $losusersdelclient = User::where('client_id',$client->id)->get();
             
                foreach ($losusersdelclient as $user) {
                    if($user->role_id == 6){
                    
                        $mail = $user->email;
                        $client->deudor = $user->name;
                        //$mail = 'nestor.sandoval@digitaladmintrack.com';
                        $mail = 'alanisdg@gmail.com';
                        $m = Mail::to($mail)->send(new PaymentAlerts($client));

                         
                    }
                }
            }

            //MISMO DIA
            if($alert_client_day == $today){ 
                 $losusersdelclient = User::where('client_id',$client->id)->get();
             
                foreach ($losusersdelclient as $user) {
                    if($user->role_id == 6){
                    
                        $mail = $user->email;
                        $client->deudor = $user->name;
                        //$mail = 'nestor.sandoval@digitaladmintrack.com';
                        $mail = 'alanisdg@gmail.com';
                        $m = Mail::to($mail)->send(new SameDay($client));

                         
                    }
                }
            }

            //UN DIA ANTES DEL CORTE
            if($dayAfterSuspenson == $today){
                 $losusersdelclient = User::where('client_id',$client->id)->get();
             
                foreach ($losusersdelclient as $user) {
                    if($user->role_id == 6){
                    
                        $mail = $user->email;
                        $client->deudor = $user->name;
                        //$mail = 'nestor.sandoval@digitaladmintrack.com';
                        $mail = 'alanisdg@gmail.com';
                        $m = Mail::to($mail)->send(new DayBeforeSuspension($client));

                         
                    }
                }
            }

            //SUSPENSION
            if($SuspensonDay == $today){
                 $losusersdelclient = User::where('client_id',$client->id)->get();
             
                foreach ($losusersdelclient as $user) {
                    if($user->role_id == 6){
                    
                        $mail = $user->email;
                        $client->deudor = $user->name;
                        //$mail = 'nestor.sandoval@digitaladmintrack.com';
                        $mail = 'alanisdg@gmail.com';
                        $m = Mail::to($mail)->send(new SuspensionDay($client));

                         
                    }
                }

                
            } 
            }

            





        }
    }

  

}