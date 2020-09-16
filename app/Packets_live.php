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

}
