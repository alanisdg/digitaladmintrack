<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Notifications extends Model
{
    protected $fillable = ['user_id','author_id','link','read','new_notifications','tcode_id','nde_id','client_id','route_id','driver_id','subclient_id','device_id','tstate_id','location_id','boxs_number','box_id','additionalbox_id'];

    public function tcode(){
        return $this->belongsTo(Tcodes::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function nde(){
        return $this->belongsTo(Ndes::class);
    }
    public function author(){
        return $this->belongsTo(User::class);
    }
    public function timeago($time){
        $lastReportPacket = new Carbon($time, 'America/Monterrey');

        $now = Carbon::now('America/Monterrey');
        $timeforhumans = $now->diffForHumans($lastReportPacket);
        return($timeforhumans);
    }
}
