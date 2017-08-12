<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toclients extends Model
{

    protected $fillable = ['name','description','phone','phone_2','subclients_id','geofences_id','direction','email'];

    public function geofences(){
        return $this->belongsTo(Geofences::class);
    }

}
