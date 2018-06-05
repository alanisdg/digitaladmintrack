<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','devices','role_id','client_id','new_notifications','cell','cell_up'
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
    public function comission($m,$y,$id){
        
        $total = '';
        $comissions = Comissions::where( DB::raw('MONTH(date)'), '=', $m )->where( DB::raw('YEAR(date)'), '=', $y )->where('user_id',$id)->get();
        foreach ($comissions as $comission) {
            $total = $total + $comission->subtotal;
        }

        return $total;
    }

    public function commisions_by_month($m,$y,$id)
    {
        $comissions = Comissions::where( DB::raw('MONTH(date)'), '=', $m )->where( DB::raw('YEAR(date)'), '=', $y )->where('user_id',$id)->get();
 
        return $comissions;
    }

        public function real_commission($id,$contributor){
        
        $total = '';
        $comissions = Comissions::where('user_id',$id)->get();
        foreach ($comissions as $comission) {
            $total = $total + $comission->subtotal;
        }

        $total_inversion = $contributor->total_inversion($contributor->id);

        $total = $total - $total_inversion;
        if($id == 44){
            $total = ' - ';
        }
        return $total;
    }

    public function total_comission($id){
        
        $total = '';
        $comissions = Comissions::where('user_id',$id)->get();
        foreach ($comissions as $comission) {
            $total = $total + $comission->subtotal;
        }

        return $total;
    }


    public function total_inversion($id){
        
        $total = '';
        $comissions = Gastos::where('user_id_p',$id)->get();
        foreach ($comissions as $comission) {
            $total = $total + $comission->subtotal;
        }

        return $total;
    }

    public function deuda_total($id){
        
        $total = '';
        $comissions = Gastos::where('user_id_p',$id)->get();
        foreach ($comissions as $comission) {
            $total = $total + $comission->subtotal;
        }

        $total_inversion = $total;
        $total_comission = '';

        $comissions = Comissions::where('user_id',$id)->get();
        foreach ($comissions as $comission) {
            $total_comission = $total_comission + $comission->subtotal;
        }

        $deuda_total = $total_inversion - $total_comission;

        if($deuda_total < 0 OR $id==44){
            $deuda_total = ' Sin deuda ';
        }


        return $deuda_total;
    }

    public function ingreso_by_month($month,$year){
        
         $ingresos = Ingresos::where( DB::raw('MONTH(date)'), '=', $month )->where( DB::raw('YEAR(date)'), '=', $year )->get();
         $total = '';
         foreach ($ingresos as $ingreso) {
            $total = $total + $ingreso->subtotal;
         }
        return $total;
    }

    public function gasto_by_month($month,$year){
        
         $ingresos = Gastos::where( DB::raw('MONTH(date)'), '=', $month )->where( DB::raw('YEAR(date)'), '=', $year )->get();
         $total = '';
         foreach ($ingresos as $ingreso) {
            $total = $total + $ingreso->subtotal;
         }
        return $total;
    }

    public function getDevices($user,$client){
        if($user->role_id==1){
        $devices = $client->devices;

        }else {
            $devices = $user->devices_by_user;
        }
        $ides = '';
        foreach ($devices as $device) {
            $ides .= $device->id . ',';
        }
        
        $ides = substr($ides, 0, -1);
     
        $p = DB::select('SELECT *
FROM packets_lives
WHERE updateTime IN (
    SELECT MAX(updateTime) FROM packets_lives WHERE devices_id IN ('.$ides.') GROUP BY devices_id
);');
    
        foreach ($devices as $device) {
            foreach ($p as $packet) {
                if($device->id == $packet->devices_id){
                    $device->lastpacket = $packet;
                }
            }
        }
        //SELECT MAX(updateTime) FROM packets_lives WHERE devices_id IN (1,3) GROUP BY devices_id
       /* foreach ($devices as $device) {
             $lastPacket = Packets_live::where('devices_id',$device->id)->orderBy('id','desc')->first();
            // dd($lastPacket);
           if($lastPacket == null){
             $lastPacket = Packets::where('devices_id',$device->id)->orderBy('id','desc')->first();
             
         }; 
         $device->lastpacket=$lastPacket;
        } */
        return $devices;



        



    }
  public function getBoxes($user,$client){
        if($user->role_id==1){
           
            
        
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
        $ides = '';
        foreach ($devices as $device) {
            $ides .= $device->id . ',';
        }
        
        $ides = substr($ides, 0, -1);
        //dd($ides);
        if($ides == false){

            return false;
        }
        $p = DB::select('SELECT *
FROM packets_lives
WHERE updateTime IN (
    SELECT MAX(updateTime) FROM packets_lives WHERE devices_id IN ('.$ides.') GROUP BY devices_id
);');
    
        foreach ($devices as $device) {
            foreach ($p as $packet) {
                if($device->id == $packet->devices_id){
                    $device->lastpacket = $packet;
                    if(empty($device->lastpacket)){
                        $lastPacket = Packets::where('devices_id',$device->id)->orderBy('id','desc')->first();
                        $device->lastpacket =$lastPacket;
                    }
                }
            } 
        }
        foreach ($devices as $device) {
            if(empty($device->lastpacket)){
                        $lastPacket = Packets::where('devices_id',$device->id)->orderBy('id','desc')->first();
                        $device->lastpacket =$lastPacket;
                    }
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