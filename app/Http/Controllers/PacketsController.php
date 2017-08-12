<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packets;
use App\User;
use App\Devices;
use Auth;
class PacketsController extends Controller
{
    public function packets($id){
        $user = User::find(Auth::user()->id);
        $device = Devices::find($id);
        $packets = Packets::where('devices_id','=',$id)->limit(100)->orderBy('id', 'DESC')->get();
        return view('admin.packets', compact('packets','user','device'));
    }

    public function device(){
        $devices = Devices::where('id','=',5)
        ->get();
        return view('admin.devices', compact('devices'));
    }

    public function refreshPacket()
    {

        $device = Devices::find(request()->get('device_id') );
        $geofences = request()->get('geofence');
        $geofence_message = $geofences;
        if(isset($device->travel->id))
        {
            $device_travel = true;
            $time = $device->leftTime($device->travel->arrival_date);
            $message = 'Unidad en movimiento con viaje asignado';
            $box_color = 'red';
        }else{
            // UNIDAD EN MOVIMIENTO SIN VIAJE
            $device_travel = false;
            $time =false;
            $message = 'Unidad en movimiento sin viaje asignado';
            $box_color = 'red';
        }
        //
        return response()->json([
            'travel'=>$device_travel,
            'time'=>$time,
            'geofence_message'=>$geofence_message,
            'message'=>$message,
            'box_color'=>$box_color
        ]);

    }


}
