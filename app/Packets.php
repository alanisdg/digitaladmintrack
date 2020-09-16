<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packets extends Model
{
    public function Device(){
        return $this->belongsTo(Devices::class);
    }

    public function getlts($tank,$device,$volt_report){

        if($volt_report == 0){
            return 0;
        }
       $voltmenor = 0;
          $litrosmenor = 0;
        //$tank = 1;
        //$device = Devices::find(6);
        //$volt_report = 4500;
        //$volt_report = $volt_report / 1000;
        if($tank == 1){
            $calibration = json_decode($device->calibration1,true);
        }
        if($tank == 2){
            $calibration = json_decode($device->calibration2,true);
        }
        if($tank == 3){
            $calibration = json_decode($device->calibration3,true);
        }

       
        foreach ($calibration as $k => $value) {
            foreach ($value as $volt => $lts) {
                if($volt_report <= $volt){
                    $voltmayor = $volt;
                    $litrosmayor = $lts;

                    $diferenciadevolts = $voltmayor - $voltmenor; 
            $diferenciadelitros = $litrosmayor - $litrosmenor; 
            $voltsporcalcular = $volt_report - $voltmenor; 

            $a = $voltsporcalcular * $diferenciadelitros;
            
            $a = $a/$diferenciadevolts;
            
            $litros = $a + $litrosmenor;
             return $litros;
                }

                $voltmenor = $volt;
          $litrosmenor = $lts;

            }
        }
       
        
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
