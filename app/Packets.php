<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packets extends Model
{
    public function Device(){
        return $this->belongsTo(Devices::class);
    }
    public function parseEvent($event){
    	$e = $event;
    	if($e == 20){
    		$e = 'Apagado de motor ' . $event;
    	}
    	if($e == 30){
    		$e = 'Posición ' . $event;
    	}
    	if($e == 21){
    		$e = 'Encendido de motor ' .$event;
    	}
    	if($e == 68){
    		$e = 'desconexíon de equipo ' . $event;
    	}
    	if($e == 69){
    		$e = 'conexión de equipo ' . $event;
    	}

    	if($e == '90'){
    		$e = 'Velocidad máxima sobrepasada ' . $event;
    	}
    	if($e == '91'){
    		$e = 'Velocidad normalizada ' . $event;
    	}
 


        return $e;
    }

     
}
