<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $fillable = ['name','destination_id','origin_id','references_route'];

    public function origin(){
        return $this->belongsTo(Geofences::class);
    }

    public function destination(){
        return $this->belongsTo(Geofences::class);
    }


}
