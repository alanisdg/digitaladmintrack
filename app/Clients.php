<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = ['name','description','phone','phone_2','client_id','boxs'];

    public function devices(){
        return $this->belongsToMany(Devices::class);
    }
    public function getDevicesAtrribute(){
        return $this->devices()->pluck('devices_id')->toArray();
    }
} 
