<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locations extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','phone','phone_2','subclients_id','geofences_id','direction','email'];

    protected $dates = ['deleted_at'];

    public function geofences(){
        return $this->belongsTo(Geofences::class);
    }

}
