<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Devices;
use App\Travels;
use App\Drivers;
use App\Routes;
use App\Signes;
use App\Bengines;

trait DevicesTraits 
{
    function updateTravelStatus($departure_date,$arrival_date,$device_id,$device,$boxs_id,$additionalbox_id)
    {
        //OBTENER EL ESTADO ACTUAL DEL VIAJE

        $now = Carbon::now('America/Monterrey');

        if($now->gt($departure_date) AND $now->gt($arrival_date)){
                $status = 4;
        }
        if($now->gt($departure_date) AND $now->lt($arrival_date)){
            $status = 2;
        }
        if($now->lt($departure_date) AND $now->lt($arrival_date) ){
            $status = 1;
        }

        $actual_state = $device->travel->tstate->id;

        $now_state = $status;
        // SI EL VIAJE TUVO UN CAMBIO ACUATULIZAR EL ESTADO DEL VIAJE
        if($now_state != $actual_state){
            /*
            $travel = Travels::find($device->travel->id);
            $travel->tstate_id=$now_state;
            $travel->save(); */
        }
        // SI EL VIAJE TERMINO, BORRAR EL VIAJE DEL EQUIPO
        if($status == 4){
/*
            //ACTUALIZAR CHOFER

            $driver = Drivers::find($device->travel->driver->id);
            $driver->status=0;
            $driver->save();

            $device = Devices::find($device_id);
            $device->status = 0;
            $device->travel_id=null;
            $device->boxs_id=null;
            $device->tcode_id=null;
            $device->save();

            //ACUATULIZAR CAJA 1
            if($boxs_id != null){
                $box = Devices::find($boxs_id);
                $box->status = 0;
                $box->travel_id=null;
                $box->boxs_id=null;
                $box->save();
            }


            //ACTUALIZAR CAJA 2
            if($additionalbox_id != null){
                $additionalbox = Devices::find($additionalbox_id);
                $additionalbox->status = 0;
                $additionalbox->travel_id=null;
                $additionalbox->boxs_id=null;
                $additionalbox->save();
            }
*/


        }
    }

    function getTravelStatus($departure_date,$arrival_date,$device){
        $now = Carbon::now('America/Monterrey');
        if($now->gt($departure_date) AND $now->gt($arrival_date)){
            $status = 4;
        }
        if($now->gt($departure_date) AND $now->lt($arrival_date)){
            $status = 2;
        }
        if($now->lt($departure_date) AND $now->lt($arrival_date) ){
            $status = 1;
        }
        return $status;
    }

    function getTravelStatusByGeofence($departure_date,$arrival_date,$device,$route_id){
        $route = Routes::find($route_id);
        $origin_id = $route->origin_id;

        $search_origin = Signes::where('geofence_id',$origin_id)
        ->where('device_id',$device->id)
        ->whereBetween('updateTime',array($departure_date,$arrival_date))
        ->orderBy('id','desc')->first();
 
        if($search_origin == null){
            return 1;
        }else{
            if($search_origin->status == 0){
            return 2;
            }
            if($search_origin->status == 1){
            return 8;
            }
        }  
    }
    function getTravelStatusByGeofence2($departure_date,$arrival_date,$device,$route_id){
        $route = Routes::find($route_id);
        $origin_id = $route->origin_id;
        $destination_id = $route->destination_id;
        
         
        $search_origin = Signes::where('geofence_id',$origin_id)
        ->where('device_id',$device)
        ->whereBetween('updateTime',array($departure_date,$arrival_date))
        ->orderBy('id','desc')->first();


      

        

        $eldevice = Devices::find($device);
        
        $geofences = json_decode($eldevice->geofences,true);
        
        if($search_origin == null){
            $code = 1;
            // SI NO SE ENCONTRO ORIGEN BUSQUEMOS SI SE ENCUENTRA DENTRO DE UNA GEOCERCA
            foreach ($geofences as $geofence => $id) {
            //dd($geofence,$id);
            if($id == 1){
                if($geofence == $origin_id){
                    $code = 8;
                }
            }
        }
        }else{
            if($search_origin->status == 0){
            $code = 2;
            }
            if($search_origin->status == 1){
            
            }
        } 
        $search_destination = Signes::where('geofence_id',$destination_id)
        ->where('device_id',$device)
        ->where('updateTime','>',$departure_date)
        ->orderBy('id','desc')->first();
         
        if($search_destination != null){
            if($search_destination->status == 1){
                $code = 9;
            }
        }
        
        return $code; 


    }


    function parseReport($packets,$device,$to,$from){
        $engine_on = '';
        $engine_off = ''; 
 
        $bengines = Bengines::where('device_id',$device)->whereBetween('updateTime', array($to, $from))->get();
        
   
        $go =false;
        $engine_stop = array();
        foreach ($bengines as $bengines) {
            $status = $bengines->bad;
            if($status == 1){
                $go=true;
            }
            if($go==true){
                if($status == 1){
                    $starttime = $bengines->updateTime;
                    $lat = $bengines->lat;
                    $lng = $bengines->lng;
                    $go=true;
                }
                if($status == 0){
                    $endtime = $bengines->updateTime;
                    $go=false;
                    $from = new Carbon($starttime, 'America/Monterrey');
                    $to = new Carbon($endtime, 'America/Monterrey');
                    $dif = $to->diffInMinutes($from);

                    if($dif > 60){
                      $hours = floor($dif / 60); // Get the number of whole hours
                      $minutes = $dif % 60; // Get the remainder of the hours

                      $mov = $hours . ":" .$minutes . " horas";
                  }else{
                      $mov = $dif . " mins";
                  }

                    $stop = array($lat,$lng,$dif,$mov,$starttime,$endtime);
                    array_push($engine_stop,$stop);
                }
            }
            
        }
       //dd($engine_stop);
        $body='';
        $head='';
        $tiempo='';
        $head .='<tr>';
        $head .='<td>Fecha  </td>'; 
        $head .='<td>Latitud</td>';
        $head .='<td>Longitud</td>';
        $head .='<td>Bateria</td>';
        $head .='<td>Bateria alimentacion</td>';
        $head .='<td>Velocidad</td>';
        $head .='<td>Motor</td>';
        $head .='<td>RSSI</td>';
        $head .='<td>Evento</td>';
        $head .='<td>odometro</td>';
        $head .='<td>heading</td>';
        $head .='<td></td>';
        $head .='</tr>';
        $stoptruck = array();
        $stoptruck_engine_on = array();
        $coords = array();
        $points = array();
        $previous_value = 0;
        $movimiento = 0;
        $detenido = 0;
        $detenido_por_velocidad = 0;
        $i = 0;
        $len = count($packets);
        $stop = array();
        $dif_stop = 0;
        $kms = 0;
        $truck_status = 'on';
        $fisrtLatLng = '';
        $max = '';
        foreach ($packets as $key => $packet) {
             $body .='<tr>';
            if($packet->speed > 2){
                $truck = 'on';
            }else if($packet->speed <= 2){
                $truck = 'off';
            }

            if($packet->engine == 0){
                $engine_off = $engine_off + $packet->Timebetween;
            }
            if($packet->engine == 1){
                $engine_on = $engine_on + $packet->Timebetween;
            }

            if($i == $len - 1){
                if($truck == 'off'){
                    $packet->truck = $truck;
                    $body .='<td>ultima'.$truck.'</td>';
                    //array_push($stoptruck,$packet);  
                }
            } 

            if($truck_status != $truck){
                //hubo cambio
                if($truck == 'off'){

                }
                
                $packet->truck = $truck;
                array_push($stoptruck,$packet);
                if($packet->engine == 1){
                    array_push($stoptruck_engine_on,$packet);
                }
                $truck_status = $truck;
            }else{
                
            }
            $kms = $kms + $packet->odometro;
            if ($i == 0) {
                $fisrtLatLng = array($packet->lat,$packet->lng);
            $first_odometer = $packet->odometro;
            if($packet->speed==0){
                $s = array($packet->lat,$packet->lng);
                array_push($stop, $s);
                
            }
            
        } else if ($i == $len - 1) {
        $last_odometer = $packet->odometro;
        }

            $i++;
            $point= array('lat'=>$packet->lat,'lng'=>$packet->lng);
            array_push($coords,$point);

            $point_data= array('lat'=>$packet->lat,'lng'=>$packet->lng,'speed'=>$packet->speed,'updateTime'=>$packet->updateTime,'eventCode'=>$packet->eventCode,'rssi'=>$packet->rssi,'id'=>$packet->id,'heading'=>$packet->heading);
            array_push($points,$point_data);

           
            $body .='<td>'.$packet->updateTime."</td>";  
            $body .='<td>'.$packet->lat."</td>";
            $body .='<td>'.$packet->lng."</td>";
            $body .='<td>'.$packet->power_bat."</td>";
            $body .='<td>'.$packet->power_supply."</td>";
            $body .='<td>'.$packet->speed."</td>";
            $body .='<td>'.$packet->engine."</td>";
            $body .='<td>'.$packet->rssi."</td>";
            $body .='<td>'.$packet->parseEvent($packet->eventCode)."</td>";
            $body .='<td>'.$packet->odometro." mts</td>";
            $body .='<td>'.$packet->heading."</td>";
            $body .='<td><button lat="'.$packet->lat.'" lng="'.$packet->lng.'" class="btn btn-primary btn-xs panto goto">Ver</button></td>';

            

            // DETERMINAR TIEMPO DETENIDO Y EN MARCHA


            if($previous_value) {

               
                $tiempo .='<div>Fecha: '. $packet->updateTime." Velocidad" .$packet->speed ."- Evento: ".$packet->eventCode." - anterior: " . $previous_value->eventCode . "</div>";

                $from = new Carbon($previous_value->updateTime, 'America/Monterrey');
                    $to = new Carbon($packet->updateTime, 'America/Monterrey');
                    $dif = $to->diffInMinutes($from);

                    /*
                     if($previous_value->speed !=0 AND $packet->speed ==0){
                    // empieza periodo detenido
                    $s = array($packet->lat,$packet->lng);
                    array_push($stop,$s);
                    $dif_stop  = $dif_stop + $dif;
                    $body .= '<td> hubo cambio</d>';
                    }
                    if($previous_value->speed ==0 AND $packet->speed ==0){
                        $dif_stop  = $dif_stop + $dif;
                    }

                    if($previous_value->speed ==0 AND $packet->speed !=0){
                        // Termina periodo
                        array_push($stop,$dif);
                        $body .= '<td>b hubo cambio</d>';
                    }*/

                    // 24 comienza la marcha
                    // 25 no moving

                    /*
                     if($previous_value->speed !=0 AND $packet->speed ==0){
                        $body .= '<td> comienza detenido </d>';
                     }elseif($previous_value->speed ==0 AND $packet->speed !=0){
                        $body .= '<td> comienza movimiento </d>';
                     }elseif($previous_value->speed ==0 AND $packet->speed ==0){
                        $body .= '<td> sigue detenido </d>';
                     }elseif($previous_value->speed ==0 AND $packet->speed !=0){
                        $body .= '<td> sigue movimiento </d>';
                     }
                     */

                    if($packet->speed == 0){
                        $detenido = $detenido + $dif;
                        
                    }else{
                        $movimiento = $movimiento + $dif; 
                    }

                

            }else{
                $tiempo .='<div>Fecha: '. $packet->updateTime." Velocidad" .$packet->speed ."- Evento: " . $packet->eventCode."</div>";
            }

            if($packet->speed == 0){
                $mov_status = 0;
                
            }else{
                $mov_status = 1;
                
            }
            $previous_value = $packet;
        }

        $body .='</tr>';

          // $hours = intdiv($movimiento, 60).':'. ($movimiento % 60);
          if($movimiento > 60){
              $hours = floor($movimiento / 60); // Get the number of whole hours
              $minutes = $movimiento % 60; // Get the remainder of the hours
              $mov = $hours . ":" .$minutes . " horas";
          }else{
              $mov = $movimiento . " mins";
          }

          if($detenido > 60){
              $hours = floor($detenido / 60); // Get the number of whole hours
              $minutes = $detenido % 60; // Get the remainder of the hours
              $det = $hours . ":" .$minutes . " horas";
          }else{
              $det = $detenido . " mins";
          }
          $title ='';
         // dd($stoptruck_engine_on);

          //DETERMINAR PARADAS POR VELOCIDAD
          $go = 1;
          $stop_map_info=array();
          $maxima = 0;
          foreach ($stoptruck as $packeta) {
            $time = $packeta->updateTime;
            if($packeta->truck == 'off'){
                $lat = $packeta->lat;
                $lng = $packeta->lng;
                $de = $packeta->updateTime;
            }else{
                $a = $packeta->updateTime;
            }
            $go++;
            if($go == 3){
                $from = new Carbon($de, 'America/Monterrey');
                    $to = new Carbon($a, 'America/Monterrey');
                    $dif = $to->diffInMinutes($from);
                    $detenido_por_velocidad  = $detenido_por_velocidad + $dif;


                    if($dif > 60){
                      $hours = floor($dif / 60); // Get the number of whole hours
                      $minutes = $dif % 60; // Get the remainder of the hours

                      $mov = $hours . ":" .$minutes . " horas";
                  }else{
                      $mov = $dif . " mins";
                  }
                  if($dif > $maxima){
                    $max = array($lat,$lng,$mov);
                    $maxima = $dif;
                  }
                    $va = array($lat,$lng,$mov,$de,$to,$from,$a);
                    if($dif > 4){

                    array_push($stop_map_info, $va);
                    }
                $go=1;
            }
            //PARADAS POR VELOCIDAD
            
          } 

          $go = 1;
          $stop_map_info_engine_off = array();
          foreach ($stoptruck_engine_on as $packeta) {
            $time = $packeta->updateTime;
            if($packeta->truck == 'off'){
                $lat = $packeta->lat;
                $lng = $packeta->lng;
                $de = $packeta->updateTime;
            }else{
                $a = $packeta->updateTime;
            }
            $go++;
            if($go == 3){
                $from = new Carbon($de, 'America/Monterrey');
                    $to = new Carbon($a, 'America/Monterrey');
                    $dif = $to->diffInMinutes($from);
                    $detenido_por_velocidad  = $detenido_por_velocidad + $dif;


                    if($dif > 60){
                      $hours = floor($dif / 60); // Get the number of whole hours
                      $minutes = $dif % 60; // Get the remainder of the hours

                      $mov = $hours . ":" .$minutes . " horas";
                  }else{
                      $mov = $dif . " mins";
                  }
                  if($dif > $maxima){
                    $max = array($lat,$lng,$mov);
                    $maxima = $dif;
                  }
                    $va = array($lat,$lng,$mov,$de,$to,$from,$a);
                    if($dif > 4){

                    array_push($stop_map_info_engine_off, $va);
                    }
                $go=1;
            }
            //PARADAS POR VELOCIDAD
            
          } 
          //dd($stop_map_info_engine_off);
          $kms = $kms/1000;
          if($detenido_por_velocidad > 60){
                      $hours = floor($detenido_por_velocidad / 60); // Get the number of whole hours
                      $minutes = $detenido_por_velocidad % 60; // Get the remainder of the hours

                      $deti = $hours . ":" .$minutes . " horas";
                  }else{
                      $deti = $detenido_por_velocidad . " mins";
                  }


        $title .= '<li class="list-group-item"><b>Tiempo total detenido:</b> '.$deti . "</li>";
       // $title .= '<br> Odometro inicial: '.$first_odometer.'  <br>Odometro final:' . $last_odometer ;
        $title .= ' <li class="list-group-item"><b>Kilometros recorridos:</b> ' . $kms  . ' kms </li>';
       $stop_parse = '<ul class="list-group">';
                        foreach($stop_map_info as $key => $stop){
                            $stop_parse .='<li class="list-group-item">';
                                $stop_parse .='Detenido por <span class="goto" lat="'. $stop[0] .'" lng="' .$stop[1].'">'.$stop[2].' - '. $stop[3].'</span></li>'; 
                    
                        }
                        $stop_parse .='</ul>';

        $engine_parse = '<ul class="list-group">';


        if($engine_on > 60){
                      $hours = floor($engine_on / 60); // Get the number of whole hours
                      $minutes = $engine_on % 60; // Get the remainder of the hours

                      $en_on = $hours . ":" .$minutes . " horas";
                  }else{
                      $en_on = $engine_on . " mins";
                  }

        if($engine_off > 60){
                      $hours = floor($engine_off / 60); // Get the number of whole hours
                      $minutes = $engine_off % 60; // Get the remainder of the hours

                      $en_off = $hours . ":" .$minutes . " horas";
                  }else{
                      $en_off = $engine_off . " mins";
                  }


        $engine_parse .= '<li class="list-group-item">Motor Encendido: '. $en_on .'</li>';

        $engine_parse .= '<li class="list-group-item">Motor Apagado: '. $en_off .'</li>';
        //dd($engine_stop);
                        foreach($engine_stop as $key => $stop){
                             
                            if($stop[2] > 15){
                                //dd($stop);
                                $engine_parse .='<li class="list-group-item">';
                                $engine_parse .='Detenido por <span class="goto" lat="'. $stop[0] .'" lng="' .$stop[1].'">'.$stop[3].'</span></li>'; 
                            }
                        }
                        $engine_parse .='</ul>';
                        //dd($stop_map_info_engine_off);
//dd($engine_parse);
        $response =array($head,$body,$title,$coords,$points,$stop,$fisrtLatLng,$stoptruck,$stop_map_info,$max,$stop_parse,$engine_stop,$engine_parse);
        return $response;
        
    }
}
?>
