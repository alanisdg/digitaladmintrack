<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travels extends Model
{
    protected $fillable = ['name','postage','toclient_id','user_id','reference','active','tcode_id','client_id','route_id','driver_id','subclient_id','device_id','departure_date','arrival_date','tstate_id','location_id','boxs_number','box_id','additionalbox_id','user_id','endtraveltime','motivo'];

    public function device(){
        return $this->belongsTo(Devices::class);
    }
    public function box(){
        return $this->belongsTo(Devices::class);
    }
    public function additionalbox(){
        return $this->belongsTo(Devices::class);
    }

    public function route(){
        return $this->belongsTo(Routes::class);
    }

    public function actual(){
        return $this->belongsTo(Geofences::class);
    }

    public function driver(){
        return $this->belongsTo(Drivers::class);
    }

    public function location(){
        return $this->belongsTo(Locations::class);
    }

    public function subclient(){
        return $this->belongsTo(Subclients::class);
    }
    // tstate es importante porque es el nombre de la columna
    // state busca state_id y no funciona
    // states busca stateses_id y no funciona
    // tstate busca tstate_id y ya funciona
    public function tstate(){
        return $this->belongsTo(Tstates::class);
    }

    public function tcode(){
        return $this->belongsTo(Tcodes::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function decode_reference($references){
        if($references == ''){

            return 'Sin Referencia';
        }else{
            $references = json_decode($references);
            $r='';
            foreach ($references as $reference) {
                $r .= $reference . ",";
            }
            $r = rtrim($r, ',');
            return $r;
        }

    }

}