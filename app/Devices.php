<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use DateTime;

class Devices extends Model
{
    protected $fillable = ['name','imei','client_id','number','type_id','virtual','new','plate','block_engine','bbuton','stepBlock'];

    public function User(){
        return $this->belongsTo(User::class);
    }
    public function battery_alarm($alarm_value,$value){
        if($value < $alarm_value){
            return '<span class="glyphicon glyphicon-oil red" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Batería baja: ' . $value . '"></span>' ;
        }else{
            return '';
        }
        
    }

    public function rssi_alarm($alarm_value,$value){
        if($value < $alarm_value){
            return '<span class="glyphicon glyphicon-signal red" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Señal baja: ' . $value . '"></span>' ;
        }else{
            return '';
        }
        
    }

    public function packets(){
        return $this->hasMany(Packets::class);
    }
    public function packets_live(){
        return $this->hasMany(Packets_live::class);
    }
    public function boxs(){
        return $this->belongsTo(Devices::class);
    }

    public function route(){
        return $this->belongsTo(Routes::class);
    }

    public function driver(){
        return $this->belongsTo(Drivers::class);
    }

    public function client(){
        return $this->belongsTo(Clients::class);
    }

    public function tcode(){
        return $this->belongsTo(Tcodes::class);
    }


/*
    public function signe($id){
        $lastPacket = Packets::where('devices_id',$id)->orderBy('updateTime','desc')->first();

        if(!empty($lastPacket)){
            $lastGeofence = Signes::where('device_id',$id)->where('packet_id',$lastPacket->id)->first();
            if(!empty($lastGeofence)){
                $geofence = Geofences::where('id',12)->get();
                $geofence = $geofence;
            }else{
                $geofence = 'Sin geocerca';
            }
        }else{
            $geofence = 'Sin geocerca';
        }



        return $geofence;
    } */

    public function signe($id){
        $lastPacket = Packets::where('devices_id',$id)->orderBy('updateTime','desc')->get();

        return $lastPacket;
    }

    public function clients(){
        return $this->belongsToMany(Clients::class);
    }



    public function users(){
        return $this->belongsToMany(Users::class);
    }
    public function getClientAtrribute(){
        return $this->clients()->pluck('clients_id')->toArray();
    }

    public function travel(){
        return $this->belongsTo(Travels::class);
    }

    public function stats(){
        return $this->belongsTo(Tstatu::class);
    }

    public function status($lastPacket){
        //return $lastPacket->updateTime;
        /* $lastPacket = DB::table('packets')
        ->select('updateTime')
        ->where('devices_id',$device->id)
        ->orderBy('updateTime','DESC')
        ->first(); 


        // $lastPacket = Packets::all()->where('devices_id',$device->id)->last(); */
        if(!empty($lastPacket)){
            $lastReportPacket = new Carbon($lastPacket->updateTime, 'America/Monterrey');

            $now = Carbon::now('America/Monterrey');
            $timeforhumans = $now->diffForHumans($lastReportPacket);
            $timeforComputer = $now->diffInMinutes($lastReportPacket);



            if($timeforComputer > 30){
                $data =  '<span style="background-color:red" class="badge">'.$timeforhumans.'</span>';
            }else{
                $data =  '<span   class="badge">'.$timeforhumans.'</span>';
            }


            return $timeforComputer;
        }else{
            return 'Sin Reportes';
        }     
    }

    public function bbuton($lastPacket){
         
        if(!empty($lastPacket)){
            $lastReportPacket = new Carbon($lastPacket, 'America/Monterrey');

            $now = Carbon::now('America/Monterrey');
            $timeforhumans = $now->diffForHumans($lastReportPacket);
            $timeforComputer = $now->diffInMinutes($lastReportPacket);



            if($timeforComputer > 30){
                $data =  '<span style="background-color:red" class="badge">'.$timeforhumans.'</span>';
            }else{
                $data =  '<span   class="badge">'.$timeforhumans.'</span>';
            }


            return $timeforComputer;
        }else{
            return 0;
        }     
    }



     public function statusadmin($device){
        $lastPacket = DB::table('packets')
        ->select('updateTime')
        ->where('devices_id',$device->id)
        ->orderBy('id','DESC')
        ->first(); 
        // $lastPacket = Packets::all()->where('devices_id',$device->id)->last();
        if(!empty($lastPacket)){
            $lastReportPacket = new Carbon($lastPacket->updateTime, 'America/Monterrey');
            $now = Carbon::now('America/Monterrey');
            $timeforhumans = $now->diffForHumans($lastReportPacket);
            $timeforComputer = $now->diffInMinutes($lastReportPacket);
            if($timeforComputer > 30){
                $data =  '<span style="background-color:red" class="badge">'.$timeforhumans.'</span>';
            }else{
                $data =  '<span   class="badge">'.$timeforhumans.'</span>';
            }
            return $data;
        }else{
            return 'Sin Reportes';
        }
    }
    public function statusForHumans($lastPacket){
        

        // $lastPacket = Packets::all()->where('devices_id',$device->id)->last();
        if(!empty($lastPacket)){
            $lastReportPacket = new Carbon($lastPacket->updateTime, 'America/Monterrey');

            $now = Carbon::now('America/Monterrey');
            $timeforhumans = $now->diffForHumans($lastReportPacket);
            $timeforComputer = $now->diffInMinutes($lastReportPacket);



            if($timeforComputer > 30){
                $data =  '<span style="background-color:red" class="badge">'.$timeforhumans.'</span>';
            }else{
                $data =  '<span   class="badge">'.$timeforhumans.'</span>';
            }


            return $data;
        }else{
            return 'Sin Reportes';
        }
    }
    public function leftTime($arrival_date){
        $now = Carbon::now('America/Monterrey');
        $arrival_date = new Carbon($arrival_date, 'America/Monterrey');
        $timeforhumans = $arrival_date->diffForHumans($now);

        return $timeforhumans;
    }
    public function lastReport($last){
        date_default_timezone_set('America/Monterrey');
        $to_time = strtotime(date("Y-m-d H:i:s"));
        $from_time = strtotime($last);
        $result =  round(abs($to_time - $from_time) / 60,2);
            if($result <= 60){ return round($result). 'm'; }
            if($result >= 60 && $result	 <=1440){ return number_format(($result/60),0).'h'; }
            if($result >= 1440){ return number_format(($result/1440),0). 'd'; }
        return $result;
    }
}
