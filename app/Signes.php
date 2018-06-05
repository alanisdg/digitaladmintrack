<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signes extends Model
{
    protected $fillable = ['status','packet_id','geofence_id','device_id'];

    public function packet(){
        return $this->belongsTo(Packets::class);
    }

    public function geofence(){
        return $this->belongsTo(Geofences::class);
    }

}
