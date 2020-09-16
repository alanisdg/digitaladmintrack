<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Geofences;
use App\Locations;
use App\Toclients;
use App\Travels;
use App\Devices;
use App\States;
use App\Signes;
use App\Groups;
use App\User;
use Auth;

//INCLUIR pasat
//use Illuminate\Support\Facades\Request;

class GroupsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function insert(){
        $name = request()->get('name');
        $user_id = request()->get('user_id');
        $device_id = request()->get('device_id');
        $type = request()->get('type');
/*
        $name = 'test';
        $user_id = 1;
        $device_id = 318;
        $type = 2; */


        $devices = array();
        array_push($devices, $device_id);

        $devs = json_encode($devices);

        $group = Groups::create([
                'name' => $name,
                'user_id' =>$user_id,
                'devices' =>$devs,
                'type' => $type
            ]);

        return response()->json($group);
    }

    public function getgroups(){

        
        $device_id = request()->get('device_id');
        $user_id = request()->get('user_id');
        $type = request()->get('type');
 
       
        $groups = Groups::where('user_id',$user_id)->where('type',$type)->get();
        $html = '<ul class="list-group">';
        
        

        foreach ($groups as $group) {            
            $dev_group = json_decode($group->devices,true);
 
            if(in_array($device_id, $dev_group)== true){
 
  

                $html .= '<li class="list-group-item"> <input class="addToGroup " groupname="'.$group->name.'" user_id="'.$user_id.'" device_id="'.$device_id.'" type="checkbox" group_id="'.$group->id.'" checked>' .$group->name. '</li>';
            }else{
                $html .= '<li class="list-group-item"> <input class="addToGroup " groupname="'.$group->name.'" user_id="'.$user_id.'" device_id="'.$device_id.'" type="checkbox" group_id="'.$group->id.'" >' .$group->name. '</li>';

            }
        }

        $html .= '</ul>'; 
        return response()->json($html);
    }
public function delete(){
    $group_id = request()->get('id');
    $user_id = request()->get('user_id');

    //$group_id = 12;
    //$user_id = 1;
    $group = Groups::find($group_id);
    $devices = json_decode($group->devices,true);
    
    $allgroups = Groups::where('user_id',$user_id)->get();
    $d =  array( );
    $dev = array();
    foreach ($devices as $device) {
        $times = 0;
             foreach ($allgroups as $group) {
                  $groupdevs = json_decode($group->devices,true);
                  foreach ($groupdevs as $groupdev) {
                        if($groupdev == $device){
                            $times = $times + 1; 
                            $dev[$device]['g']=$groupdev; 
                        }
                  }
              } 
              //dd($device);
              $dev[$device]=$times; 
              
    }

    //dd($dev);

    foreach ($dev as $key => $value) {
        //dd('el ' . $key . ' ' . $value);
        if($value != 1){
            unset($dev[$key]);
        }
    }
    
    //dd($dev);
    
    $packets = Groups::where('id', $group_id)->delete();
    return response()->json($dev);
}
    public function addto(){
        $group_id = request()->get('group_id');
        $user_id = request()->get('user_id');
        $device_id = request()->get('device_id');

     /*  $group_id = 3;
        $user_id = 1;
        $device_id = 267; */


        $group = Groups::find($group_id);
       
        $devs = json_decode($group->devices,true);
        if(count($devs)==0){
            array_push($devs, $device_id);
        }else{
            foreach ($devs as $dev) {
            $n = 'si';
            if($dev == $device_id){
                $n = 'no';
            }
            }
            if($n == 'si'){
                array_push($devs, $device_id);
            }
        }
        
   
        $group->devices = json_encode($devs);
        $group->save();
        return response()->json($group);
    }

    public function removeto(){
        $group_id = request()->get('group_id');
        $user_id = request()->get('user_id');
        $device_id = request()->get('device_id');
/*
        $group_id = 3;
        $user_id = 1;
        $device_id = 267;
*/



        $group = Groups::find($group_id);
        $devs = json_decode($group->devices,true);

        foreach ($devs as $key => $dev) {
            
            if($dev == $device_id){

               unset($devs[$key]);
            }
        }
        
        $group->devices = json_encode($devs);
        $group->save();

        $groups= Groups::all();
        $g = 0;
        foreach ($groups as $group) {
            $dev_group = json_decode($group->devices);
            foreach ($dev_group as $dev) {
                if($dev == $device_id){
                    $g = 1;
                }
            }
        }

         
        $arr = array('status' => $g, 'groups' => $group);

$arr =  json_encode($arr);
        return response()->json($arr);
    }
    
}
