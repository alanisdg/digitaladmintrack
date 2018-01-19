<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = ['name','description','charge_at','device_price','phone','phone_2','client_id','boxs'];

    public function devices(){
        return $this->belongsToMany(Devices::class)->where('type_id',1)->orderBy('name','asc');;
    }

    public function boxes(){
        return $this->belongsToMany(Devices::class)->where('type_id',2)->orderBy('name','asc');;
    }
    public function allDevices(){
        return $this->belongsToMany(Devices::class)->orderBy('name','asc');;
    }

    public function getDevicesAtrribute(){
        return $this->devices()->pluck('devices_id')->toArray();
    }
    public function getBoxsAtrribute(){
        return $this->boxes()->pluck('devices_id')->toArray();
    }
    public function device_price($device,$price){
        if($device->stop_charge == 1){
            return 'cancelado';
        } 
        if($device->special_price == 0 AND $device->stop_charge == 0){
            return $price;
        }else if($device->special_price != 0 AND $device->stop_charge == 0){
            return $device->special_price;
        }
        
    }

        public function device_price_public($device,$price){
        if($device['stop_charge'] == 1){
            return 'cancelado';
        }
        if($device['special_price'] == 0 AND $device['stop_charge'] == 0){
            return $price;
        }else if($device['special_price'] != 0 AND $device['stop_charge'] == 0){
            return $device['special_price'];
        }
        
    }
    
} 