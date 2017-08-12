<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','devices','role_id','client_id','new_notifications'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function devices_by_user(){
        return $this->belongsToMany(Devices::class)->where('type_id',1)->orderBy('name','asc');
    }
 

    public function role(){
        return $this->belongsto(Roles::class);
    }

    public function client(){
        return $this->belongsto(Clients::class);
    }

    public function getDevices($user){
        if($user->role_id==1){
            $devices = Devices::where('client_id',$user->client_id)->where('type_id',1)->orderBy('name','asc')->get();

        }else {
            $devices = $user->devices_by_user;
        }
        foreach ($devices as $device) {
             $lastPacket = Packets_live::where('devices_id',$device->id)->orderBy('id','desc')->first();
            // dd($lastPacket);
           if($lastPacket == null){
             $lastPacket = Packets::where('devices_id',$device->id)->orderBy('id','desc')->first();
             
         }; 
         $device->lastpacket=$lastPacket;
        }
        return $devices;
    }

    public function getAllDevices($user){
        $devices = Devices::where('client_id',$user->client_id)->orderBy('type_id','asc')->get();
        return $devices;
    }

    public function getBoxes($user){ 
            $devices = Devices::where('client_id',$user->client_id)->where('type_id',2)->orderBy('status','desc')->get();
        
         
        foreach ($devices as $device) {
             $lastPacket = Packets_live::where('devices_id',$device->id)->orderBy('updateTime','desc')->first();
            
           if($lastPacket == null){
             $lastPacket = Packets::where('devices_id',$device->id)->orderBy('updateTime','desc')->first();
             
         }; 
         $device->lastpacket=$lastPacket;
         $travel = Travels::where('box_id',$device->id)->first();
         if(isset($travel->route->destination_id)){
            $geofence = Geofences::find($travel->route->destination_id);
         
         $device->lastDestination = $geofence;
         }
            
        }
        return $devices;
    }

}
