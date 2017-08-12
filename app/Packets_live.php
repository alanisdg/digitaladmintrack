<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packets_live extends Model
{
    public function Device(){
        return $this->belongsTo(Devices::class);
    }

    public function LastPacket(){
        return 'last';
    }


}
