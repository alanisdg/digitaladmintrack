<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thits extends Model
{


    public function route(){
        return $this->belongsTo(Routes::class);
    }

    public function travel(){
        return $this->belongsTo(Travels::class);
    }

    public function packet(){
        return $this->belongsTo(Packets::class);
    }
    public function geofence(){
        return $this->belongsTo(Geofences::class);
    }

    public function tcode(){
        return $this->belongsTo(Tcodes::class);
    }



}
