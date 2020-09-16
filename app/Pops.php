<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pops extends Model
{
    protected $fillable = ['comentario','user_id','devices_id','user_name'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function timeago($time){
        $lastReportPacket = new Carbon($time, 'America/Monterrey');

        $now = Carbon::now('America/Monterrey');
        $timeforhumans = $now->diffForHumans($lastReportPacket);
        return($timeforhumans);
    }

}
