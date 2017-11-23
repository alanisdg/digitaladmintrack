<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
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

    public function boxes_by_user(){
        return $this->belongsToMany(Devices::class)->where('type_id',2)->orderBy('name','asc');
    }


    public function all_devices_by_user(){
        return $this->belongsToMany(Devices::class)->orderBy('name','asc');
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
            $user = User::find($user->id);
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $devices = $client->devices;

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
  public function getBoxes($user){
        if($user->role_id==1){
           
            $user = User::find($user->id);
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $devices = $client->boxes;

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
        public function getBoxes2($user){ 

        $client_id = Auth::user()->client_id;
        $client = Clients::find($client_id);
        $devices = $client->boxes;
 
        foreach ($devices as $device) {
             $lastPacket = Packets_live::where('devices_id',$device->id)->orderBy('updateTime','desc')->first();
            
           if($lastPacket == null){
             $lastPacket = Packets::where('devices_id',$device->id)->orderBy('updateTime','desc')->first();
             
         }; 
         $device->lastpacket=$lastPacket;
         //$travel = Travels::where('box_id',$device->id)->first();
         
         
           /* if($device->geofences !=null){
            $geofences = json_decode($device->geofences,true) ;
                foreach ($geofences as $geofence => $valor ) {
                    if($geofence == $id){
                        if($valor == 1){
                            array_push($devices,$truck->id);
                        }
                    }
                }
            } */
      


         //BUSCABA LA ULTIMA UBICACION QUE TUVO LA CAJA EN UN VIAJE
         /*
         if(isset($travel->route->destination_id)){
            $geofence = Geofences::find($travel->route->destination_id);
            $device->lastDestination = $geofence;
         } */
            
        }
        return $devices;
    }




    public function getAllDevices($user){
        if($user->role_id==1){
            
            $user = User::find($user->id);
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $devices = $client->allDevices;

        }else {
            $devices = $user->all_devices_by_user;
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

        public function AllDevices($user){
  
            
            $user = User::find($user->id);
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $devices = $client->allDevices;

      
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

    public function permissions($user){
        if($user->role->id==1 OR $user->role->id==2){
            return 'all';
        }
        $permissions = json_decode($user->permissions,true);
        if($permissions == null){
            $o = array();
            return $o;
        }
        return $permissions;
    }

}