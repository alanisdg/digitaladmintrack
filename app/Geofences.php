<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Geofences extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','lat','status','lng','id_client','type','radius','gcat_id','poly_data','color','state_id','city'];

    protected $dates = ['deleted_at'];

    public function gcat(){
        return $this->belongsTo(Gcats::class);
    }

    public function state(){
        return $this->belongsTo(States::class);
    }

    public function report($geofence_id,$device_id){
        $report = Signes::where('geofence_id',$geofence_id)->where('device_id',$device_id)->orderBy('id','desc')->first();
        dd($report);
        $packet = Packets::find($report->packet_id);

        return $packet->updateTime;
    }
}
