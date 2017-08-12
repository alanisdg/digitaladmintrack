<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configs extends Model
{
     

    public function client(){
        return $this->belongsTo(Clients::class);
    }

}
