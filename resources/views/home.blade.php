    @extends('layouts.master')
    @section('content')
    <div class="row">
        <div class="col-md-3 devices-left">
        <p class="asign_left">UNIDADES ASIGNADAS</p>
            <input type="text" id="search_left" style="width:100%" placeholder="  Buscar Unidad"></input>
            <span class="moveTop"></span>
            <?php $onroad_devices=0 ?>
            @foreach($devices  as $device)

            @if($device->status==1 AND $device->type_id==1) 
            <?php $onroad_devices++ ?>
            @if($device->travel->tstate->id == 2)
            <?php $color_class = 'bg-blue'; $state = 'en ruta';?>
            <!--en ruta-->
            @endif
            @if($device->travel->tstate->id == 1)
            <!--por salir-->
            <?php $color_class = 'bg-orange'; $state = 'por salir';?>
            @endif
            @if($device->travel->tstate->id == 8)
            <?php 
                $color_class = 'bg-green';
                $state = 'cargando';
             ?>
            <!--cargando-->
            @endif
            @if($device->travel->tstate->id == 9)
            <?php $color_class = 'bg-purple'; $state = 'descargando';?>
            <!--descargando-->
            @endif
            @if(isset($device->lastpacket->lat ))
            <div class="device device-off  animate device_{{ $device->id }}" name="{{ $device->name }}">
                <div class="">
                    
                         <div class="byside2" style="width:25%"><input type="checkbox" class="showDevice" ide="{{ $device->id }}" checked>
                            <a class="white goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
                        lng = "{{ $device->lastpacket->lng }}" style="float:left">
                        <span data-toggle="tooltip" data-placement="top" title="@if($device->boxs_id != null) -> {{ $device->boxs->name }} @endif">{{ ucfirst($device->name) }}  </span>
                                        </a> </div>

                        <div class="byside2" style="width:46%">

                                     <span  data-toggle="modal" data-target="#myModal{{ $device->id }}"  ide="{{ $device->id }}" class="panic{{ $device->id }} glyphicon  icon-stop red panicmodal @if($device->panic == 0)   none @endif " aria-hidden="true"></span>
                                     <!-- Button trigger modal -->
  

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{ $device->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content panicContent">
                                          <div class="modal-header"> 
                                            <div id="panicMap{{ $device->id }}" class="panicMap"></div>
                                            
                                          </div>
                                          <div class="modal-body ">
                                            
                                            <div class="col-md-12">
                                                    <h4 class="modal-title elh4rojo" id="myModalLabel">Boton de Pánico - {{ $device->name }}</h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="laproja">Fecha <br> <span class="elspan" id="timePanic{{ $device->id }}"></span></p>
                                                    <p class="laproja">Velocidad <br> <span class="elspan" id="speedPanic{{ $device->id }}"></span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="laproja">Motor <br> <span class="elspan" id="motorPanic{{ $device->id }}"></span></p>
                                                    <p class="laproja">Rssi <br> <span class="elspan" id="rssiPanic{{ $device->id }}"></span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="laproja">Latitud <br> <span class="elspan" id="latPanic{{ $device->id }}"></span></p>
                                                    <p class="laproja">Longitud <br> <span class="elspan" id="lngPanic{{ $device->id }}"></span></p>
                                                </div>
                                              
                                            
                                             
                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-red finishPanic" ide="{{ $device->id }}" data-dismiss="modal">Terminar Alerta</button> 
                                            <button type="button" class="btn btn-blue" data-dismiss="modal">Cerrar</button> 
                                          </div>
                                        </div>
                                      </div>
                                    </div>


                                    @if($device->engine == 1)
                                    <span class="engine{{ $device->id }}  icon-engine leicon green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>
                                    @endif 
                                    @if($device->engine === 0)
                                    <span class="engine{{ $device->id }} icon-engine leicon red" data-toggle="tooltip" data-placement="top" title="Unidad Apagada"></span> 
                                    @endif 


                                    @if($device->stop == 0)
                                    {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon green" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span> 
                                    @else
                                    {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon red" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span> 
                                    @endif
                                    
                                    @if( $device->lastpacket->speed > 100)
                                    <span class="icon-speedometer leicon red  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ number_format($device->lastpacket->odometro_total/1000, 1, '.', ',') }} kms"></span> <!--<span class="red"> {{ $device->lastpacket->speed }} km/h</span>-->
                                    @else
                                    <span class="icon-speedometer leicon shutdown  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ number_format($device->lastpacket->odometro_total/1000, 1, '.', ',') }} kms"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                                    @endif

                                    
                                    {!! $device->battery_alarm($config->battery_alarm,$device->lastpacket->power_bat) !!}
                                    {!! $device->rssi_alarm($config->rssi_alarm,$device->lastpacket->rssi) !!}  </a>

                       
                            <div class="clear"></div>
                        </div>
                        <div class="byside2" style="width:25%; font-size:10px;"><span class="<?php echo $color_class ?> device_{{ $device->id }}" id="state_{{ $device->id }}"><?php echo strtoupper($state) ?> </span></div>
                        <div class="clear"></div>
                        <div class="down">
                            <p class="text11 timerText" style="float:left">
                                <?php  if( $device->status($device->lastpacket) > 60){
                                    echo $device->statusForHumans($device->lastpacket);
                                }else{
                                    ?><span class="timer{{ $device->id }}"></span><?php
                                }   ?>
                            </p>
                            <p class="text11" style="float:right">
                                
                               
                                <a href="/travel/{{ $device->travel->tcode->id }}">{{ str_limit(ucfirst($device->travel->route->destination->name), $limit = 15, $end = '...') }} </a>
                              
                            </p>
                            <div class="clear"></div>
                                    </div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>

                    </div>
                    
@else
                                <!--EQUIPO SIN PAQUETES-->
                                <div class="device">
                                {{ ucfirst($device->name) }} Equipo nuevo.
                                </div>
                                @endif
                        @endif
                        @endforeach
                        @if($onroad_devices==0   )
                        <p style="padding: 10px; text-align: center; color: grey;">No tienes equipos en ruta</p>
                        @endif
                    </div>
                    
                    <div   id="map" style="float:right">
                         
                    </div>

                    <div class="col-md-3 devices-right">
                        <div class="content_devices none"></div>
                        <div class="one selectedone oneone select_type" dev="0"><a id="" class="  butonSelect  " >Equipos</a></div>
                        <div class="one select_type" dev="1"><a id="" class=" butonSelect  " >Cajas</a></div>
                        <p class="asign">UNIDADES SIN ASIGNAR</p>
                        <input type="text" id="search_right" style="width:100%" placeholder="  Buscar Unidad"></input>
                    <span class="rightTop"></span>
                        
                        @foreach($devices  as $device)
                        @if($device->status==0)
                        <?php $devices_availables++ ?>

                        
                                @if(isset($device->lastpacket->lat ))
                                <div class="device device-off device_{{ $device->id }}  @if($device->dstate_id==1) flash animated msv @endif" name="{{ $device->name }}">
                            <div class="" style="padding-top:3px">
                                    <div class="byside"><input type="checkbox" class="showDevice" ide="{{ $device->id }}" checked>
                                <a class="white goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
                                    lng = "{{ $device->lastpacket->lng }}" style="float:left"> {{ str_limit(ucfirst($device->name), $limit = 15, $end = '...') }} </a>
                                     </div>
                                    <div class="byside">
                                

                                     <span  data-toggle="modal" data-target="#myModal{{ $device->id }}"  ide="{{ $device->id }}" class="panic{{ $device->id }} glyphicon  icon-stop red panicmodal @if($device->panic == 0)   none @endif " aria-hidden="true"></span>
                                     <!-- Button trigger modal -->
  

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal{{ $device->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content panicContent">
                                          <div class="modal-header"> 
                                            <div id="panicMap{{ $device->id }}" class="panicMap"></div>
                                            
                                          </div>
                                          <div class="modal-body ">
                                            
                                            <div class="col-md-12">
                                                    <h4 class="modal-title elh4rojo" id="myModalLabel">Boton de Pánico - {{ $device->name }}</h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="laproja">Fecha <br> <span class="elspan" id="timePanic{{ $device->id }}"></span></p>
                                                    <p class="laproja">Velocidad <br> <span class="elspan" id="speedPanic{{ $device->id }}"></span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="laproja">Motor <br> <span class="elspan" id="motorPanic{{ $device->id }}"></span></p>
                                                    <p class="laproja">Rssi <br> <span class="elspan" id="rssiPanic{{ $device->id }}"></span></p>
                                                </div>
                                                <div class="col-md-4">
                                                    <p class="laproja">Latitud <br> <span class="elspan" id="latPanic{{ $device->id }}"></span></p>
                                                    <p class="laproja">Longitud <br> <span class="elspan" id="lngPanic{{ $device->id }}"></span></p>
                                                </div>
                                              
                                            
                                             
                                          </div>
                                          <div class="modal-footer">
                                                <button type="button" class="btn btn-red finishPanic" ide="{{ $device->id }}" data-dismiss="modal">Terminar Alerta</button> 
                                            <button type="button" class="btn btn-blue" data-dismiss="modal">Cerrar</button> 
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    @if($device->engine == 1)
                                    <span class="engine{{ $device->id }}  icon-engine leicon green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>
                                    @endif 
                                    @if($device->engine === 0)
                                    <span class="engine{{ $device->id }} icon-engine leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Apagada"></span> 
                                    @endif 

                                    @if($device->unplugged == 0)  
                                    
                                    @if($device->stop == 0)
                                    {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon green" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span> 
                                    @else
                                     {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span> 
                                    @endif
                                    @endif


                                    @if( $device->lastpacket->speed > 100)
                                    <span class="icon-speedometer leicon red  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ $device->lastpacket->odometro_total/1000 }}"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                                    @else
                                    <span class="icon-speedometer leicon shutdown  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ number_format($device->lastpacket->odometro_total/1000, 1, '.', ',') }} kms"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                                    @endif
                                    {!! $device->battery_alarm($config->battery_alarm,$device->lastpacket->power_bat) !!}
                                    
                                    {!! $device->rssi_alarm($config->rssi_alarm,$device->lastpacket->rssi) !!}  

                                    @if($device->engine_block == 1)  
                                    
                                    <button id="blockEngine" 
                                    class="block{{ $device->id }}   @if($device->elock===1) locking tt @elseif($device->elock===2) locked @else unlock @endif blockEngine" 
                                    data-toggle="tooltip" data-placement="top" 
                                    
                                    @if($device->elock==1)  @elseif($device->elock==2)
                                     title="Desbloquear unidad"
                                    @elseif($device->elock=='')
                                title="Bloquear unidad"
                                    @endif 


                                    @if($device->elock==1)  @elseif($device->elock==2)
                                     step='2'
                                    @elseif($device->elock=='')
                                step='1'
                                    @endif 
                                    des="@if($device->elock==1)  @elseif($device->elock==2) desbloquear @elseif($device->elock=='') bloquear @endif "   
                                    ide="{{ $device->id }}" 
                                    code="@if($device->elock==1)  @elseif($device->elock==2)!R3,17,10 @else!R3,17,8 @endif" 
                                    name="{{ $device->name }}" 
                                    number="{{ $device->number }}">
                                    @if($device->elock==1)  @else <span class="glyphicon glyphicon-stop eicon" aria-hidden="true"></span> @endif</button>
                                    @endif 


                                    
                                    <span data-toggle="tooltip" data-placement="top" title="Equipo desconectado"  class="glyphicon unplugged{{ $device->id }} icon-plug red  @if($device->unplugged == 0)   none @endif " aria-hidden="true"></span>
                                    


                                        <p class="text11 mb0" style="float:right">
                                        </p>
                                        <div class="clear"></div>
                                    </div>

                                    <div class="clear"></div> 
                                    </div>
                                    <div class="down"> 
                                        <p class="text11 timerText" style="float:left">
                                            <?php  if( $device->status($device->lastpacket) > 60){
                                                echo $device->statusForHumans($device->lastpacket);
                                            }else{
                                                ?><span class="timer{{ $device->id }}"></span><?php
                                            }   ?>
                                        </p>
                                        <p class="text11" style="float:right">
                                        </p>
                                        <div class="clear"></div> 
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                @else
                                <!--EQUIPO SIN PAQUETES-->
                                <div class="device device-off">
                                    <p style="color:white">{{ ucfirst($device->name) }} Equipo nuevo. </p>
                                </div>
                                @endif
                                @endif
                                @endforeach
                                <span id="rightBottom"></span>
                                @if($devices_availables==0)
                                <p style="padding: 10px; text-align: center; color: grey;">No tienes equipos disponibles</p>
                                @endif
                                <div style="clear:both"></div>
                            </div>


                            <!--CAJAS-->
                                            <div class="col-md-3 devices-right none boxes_container">
                                                <div class="none content_devices"></div>
                                                <div class="one  oneone select_type" dev="0"><a id="" class="  butonSelect  " >Equipos</a></div>
                        <div class="one selectedone select_type" dev="1"><a id="" class=" butonSelect  " >Cajas</a></div>


                                                 
                        <input type="text" id="search_right" style="width:100%" placeholder="  Buscar Unidad"></input>
                    <span class="rightTop"></span>
                        @foreach($boxes  as $device)
                        @if($device->status==0)
                        <?php $devices_availables++ ?>

                        
                                @if(isset($device->lastpacket->lat ))
                                <div class="device device-off device_{{ $device->id }}  @if($device->dstate_id==1) flash animated msv @endif" name="{{ $device->name }}">
                            <div class="">
                                <input type="checkbox" class="showDevice" ide="{{ $device->id }}" checked><a class="white goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
                                    lng = "{{ $device->lastpacket->lng }}" style="float:left">{{ ucfirst($device->name) }} 
                                     
                                    @if($device->engine == 1)
                                    <span class="engine{{ $device->id }}  icon-engine leicon green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>
                                    @endif 
                                    @if($device->engine === 0)
                                    <span class="engine{{ $device->id }} icon-engine leicon red" data-toggle="tooltip" data-placement="top" title="Unidad Apagada"></span> 
                                    @endif 


                                    @if($device->stop == 0)
                                    {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon green" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span> 
                                    @else
                                     {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon red" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span> 
                                    @endif
                                    
                                    <span class="icon-speedometer leicon " data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} mas"></span> <span class="speed{{ $device->id }}"> {{ $device->lastpacket->speed }} </span>
                                    
                                    {!! $device->battery_alarm($config->battery_alarm,$device->lastpacket->power_bat) !!}
                                    {!! $device->rssi_alarm($config->rssi_alarm,$device->lastpacket->rssi) !!}  </a>

                                    


                                    @if($device->engine_block == 1)
                                     <button id="blockEngine" ide="{{ $device->id }}" name="{{ $device->name }}" number="{{ $device->number }}">B</button>
                                     @endif


                                        <p class="text11 mb0" style="float:right">
                                        </p>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="down">
                                        <p class="text11" style="float:left">
                                            <?php  if( $device->status($device->lastpacket) > 60){
                                                echo $device->statusForHumans($device->lastpacket);
                                            }else{
                                                ?><span class="timer{{ $device->id }}"></span><?php
                                            }   ?>
                                        </p>
                                        <p class="text11" style="float:right">
                                        </p>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                @else
                                <!--EQUIPO SIN PAQUETES-->
                                <div class="device">
                                {{ ucfirst($device->name) }} Equipo nuevo.
                                </div>
                                @endif
                                @endif
                                @endforeach
                                <span id="rightBottom"></span>
                                @if($devices_availables==0)
                                <p style="padding: 10px; text-align: center; color: grey;">No tienes equipos disponibles</p>
                                @endif
                                <div style="clear:both"></div>
                            </div>



                        </div>
                        <style>
                        .unlock {
            width: 20px;
    color: #c4e0fe;
    margin-left: 6px;
    height: 18px;
    padding: 1px 2px;
    background: #3b99fc;
    border-radius: 10px;
    border: none !important;
    }

 



    .content_devices{ 
        line-height: 25px;
    width: 100%;
    border: 1px solid #3d444e;
    border-radius: 5px;
    padding: 10px;
    margin-bottom: 10px;
    color: grey;
    top: 0;
    background-color: #252b33;
    }
    .eicon{
        margin-top: -2px;
        padding: 0;
    }
    .panicContent{
        top:80px;
        background-color: #ef5b5b
    }
    .locking{
        height: 18px;
        border: none;
        margin-left: 5px;
        background-image: url(/images/dual.svg);
        background-color: transparent;
        width: 21px;
        /* position: absolute; */
        left: 50%;
        background-repeat: no-repeat;
        top: 50%;
        background-size: 16px;
    }

    .locked{
            width: 20px;
        color: #fc5454;
        margin-left: 6px;
        height: 16px;
        padding: 1px 2px;
        background: #efcbde;
        border-radius: 10px;
        border: none !important;
    }
    .modal-header {
    color: white; 
    padding: 0;
    border-bottom: none;
}
.modal-footer { 
    border-top: none;
}
.elh4rojo{
        color: #bd2e2e;
    font-size: 17px;
    font-weight: 100;
    border-bottom: 1px solid #e24848;
    padding-bottom: 9px;
    margin-bottom: 10px;
}
.laproja{
    color: #f9c0c0;
    font-weight: 100;
}
.elspan{
    color: white;
    font-size: 12px;
    font-weight: 400;
    font-family: Roboto;
}
.btn-red {
    color: #fff;
    background-color: #ea4646;
}
.btn-blue{
    color: #fff;
    background-color: #46acea;
}
.btn-blue:hover{
    color: #78b5da;
    background-color: #3088bd;
}
.btn-red:hover {
    color: #ef5b5b;
    background-color: #d02121;
    border: none
}
h4, .h4, h5, .h5, h6, .h6 {
    font-family: Roboto !important
}
                        </style>
                        @endsection
                        @section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
    <script src="/js/master.js"></script>
    <script>
    var infowindow;
      var letimer;
$('.finishPanic').click(function(){
    ide = $(this).attr('ide');
            $.ajax({
            url:'/device/finishPanic',
            type:'POST',
            dataType: 'json',
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: ide },
                success: function(panic){  
                
                    $('.panic'+ide).hide()
            },
            error: function(data){
                console.log(data)
                var errors = data.responseJSON;
                console.log(errors);
                }
            })
}) 
    $('.panicmodal').click(function(){
        ide = $(this).attr('ide'); 
        $.ajax({
            url:'/device/getPanic',
            type:'POST',
            dataType: 'json',
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: ide },
                success: function(panic){
                   
                    var myLatlng = new google.maps.LatLng(panic['panic'][0].lat, panic['panic'][0].lng);
                        var mapOptions = {
                            zoom: 18,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        panicmap = new google.maps.Map(document.getElementById('panicMap'+ide), mapOptions);
                        var marker = new google.maps.Marker({
                            position: myLatlng,
                            zIndex:9999999,
                            icon:{
                                url:'http://usamexgps.com/images/truck3.png'
                            },

                            map:panicmap
                        });

                        $('#timePanic'+ide).html(panic['panic'][0].updateTime)
                        $('#speedPanic'+ide).html(panic['panic'][0].speed + ' km/h')
                        $('#motorPanic'+ide).html(panic['panic'][0].engine)
                        $('#latPanic'+ide).html(panic['panic'][0].lat )
                        $('#lngPanic'+ide).html(panic['panic'][0].lng)
                        $('#rssiPanic'+ide).html(panic['panic'][0].rssi)

                     
                    
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
                }
            })
    })


    $('.select_type').click(function(){
      
        typeOfs = $(this).attr('dev');
 
        if(typeOfs == 0){
            $('.devices_container').show();
            $('.boxes_container').hide();

        }else if(typeOfs == 1){
            $('.devices_container').hide();
            $('.boxes_container').show();

        }
    })
    $("#search_right").on("keyup", function() {

    var value = $(this).val();
     
    var value = value.toLowerCase();
     console.log(value)
    $(".devices-right .device").each(function(index) {
        name = $(this).attr('name').toLowerCase(); 
        console.log(name)
        if (name.indexOf(value) !== 0) {
            console.log('no')
                $(this).hide()
            }
            else {
                console.log('si')
                $(this).show()
            }

    })

     
    });
     

    $('.blockEngine').click(function(){ 
        elcode = $(this).attr('code')
              ide= $(this).attr('ide')
              num= $(this).attr('number')

              des= $(this).attr('des')
              step= $(this).attr('step')


              elname= $(this).attr('name')
           
              $.confirm({
                title: 'Bloqueo de Motor',
                content: '<label>Deseas '+des+' el motor de la unidad '+elname+'</label>' ,
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url:'/nexmo/send',
                            type:'POST',
                            dataType: 'json',
                            headers: { 
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: { number: num, code:elcode, device_id:ide },
                            success: function(success){

                                if(step == '1'){
                                    $('.block'+ide).removeClass('unlock')
                                    $('.block'+ide).addClass('locking')
                                    $('.block'+ide).attr('code','!R3,17,10')
                                    $('.block'+ide).html('')
                                }else if(step=='2'){
                                    $('.block'+ide).removeClass('locked')
                                    $('.block'+ide).addClass('locking')
                                    $('.block'+ide).attr('code','!R3,17,8')
                                    $('.block'+ide).html('')
                                }
                                
     

                                $.ajax({
                                    url:'/device/updateBlock',
                                    type:'POST',
                                    dataType: 'json',
                                    headers: { 
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: { lock: 1 , device_id:ide , step:step},
                                    success: function(success){
                                    },
                                    error: function(data){
                                        var errors = data.responseJSON;
                                  
                                    }
                                })



                            },
                            error: function(data){
                                var errors = data.responseJSON;
                            }
                        })
                    },
                    cancel: function () {
                        $.alert('Cancelado');
                    }
                }
            }); 
        
    })


    $("#search_left").on("keyup", function() {
    var value = $(this).val();
     
    var value = value.toLowerCase();

    $(".devices-left .device").each(function(index) {
        name = $(this).attr('name'); 

        if (name.indexOf(value) !== 0) {
                $(this).hide()
            }
            else {
                $(this).show()
            }

    })

     
    });



    $(".devices-right .devices").each(function(index) {
    
    })

    function resizeMap(){
        b = $('body').height()
        laterales = b-53;
        $('.devices-right').css('height',laterales+'px')
        $('.devices-left').css('height',laterales+'px')
        n = 53
        f = $('#footer').height()
        w =$('body').width()
        bw = $('body').width() 
        bw = bw - 505 
        map_div = b - n  ;
        $('#map').css('height',map_div+'px')
        if(w > 1000){
            $('#map').css('width',bw+'px')
            $('#map').css('display','inline-block')
            $('#map').css('float','none')
            $('#map').css('position','absolute')
        }else{
            $('#map').css('width','100%')
        }
        google.maps.event.trigger(map, "resize");
    }

    $(window).resize(function() {
        resizeMap()
    });
                        SlidingMarker.initializeGlobally();
                        var marker, map;
                        var myLatlng = new google.maps.LatLng(25.674873, -100.318432);
                        var mapOptions = {
                            zoom: 12,
                            center: myLatlng,

                            mapTypeId: google.maps.MapTypeId.ROADMAP

                        }
                        map = new google.maps.Map(document.getElementById('map'), mapOptions);
                        var geocoder = new google.maps.Geocoder;
                        var infowindow = new google.maps.InfoWindow;
                        marker = new google.maps.Marker({
                            //marker = new SlidingMarker({
                            map: map,
                            title: 'I\m sliding marker'
                        });

                m = []
                mwl = []
                van =1
                 @foreach($alldevices  as $device)

                 @if(isset($device->lastpacket->lat ))
                 van++
                 sec = {{ $device->status($device->lastpacket) }} * 60;
               
                 if({{ $device->bbuton($device->bbuton) }} != 0){
                    secToBbutton = {{ $device->bbuton($device->bbuton) }} * 60;
        
                 if(secToBbutton > 30){
                    ides = {{ $device->id }}
                    if( {{ $device->stepBlock  }} == 2 ){
                  
                                $('.block'+ides).removeClass('locking')
                                $('.block'+ides).addClass('locked')
                                $('.block'+ides).attr('code','!R3,17,10')
                                $('.block'+ides).attr('des','desbloquear')
                                $('.block'+ides).attr('title','Desbloquear unidad')
                                $('.block'+ides).attr('step','2')
                                $('.block'+ides).html( '<span class="glyphicon glyphicon-stop eicon" aria-hidden="true"></span> ')
                               
                            }

                            if( {{$device->stepBlock  }} == 1){
                     
                                $('.block'+ides).removeClass('locking')
                                $('.block'+ides).removeClass('locked')
                                $('.block'+ides).addClass('unlock')
                                $('.block'+ides).attr('title','Bloquear unidad')
                                $('.block'+ides).attr('des','bloquear')
                                $('.block'+ides).attr('code','!R3,17,8')
                                $('.block'+ides).attr('step','1')
                                $('.block'+ides).html( '<span class="glyphicon glyphicon-stop eicon" aria-hidden="true"></span> ')
                               
                            }


                 }
                 }
                 truck_image = 'truck3.png'
                  @if($device->stop == 0)
                        truck_image = 'green_dot.png'
                                    @else
                                    truck_image = 'truck_red_.png'
                        @endif


                   $(".timer"+{{$device->id}}).timer({ seconds: sec, });

                         var myLatlng{{ $device->id }}= new google.maps.LatLng({{ $device->lastpacket->lat   }},{{ $device->lastpacket->lng   }} );
                          
                           @if($device->stop == 0)
                       var marker{{ $device->id }} = new google.maps.Marker({
                            position: myLatlng{{ $device->id }},
                            zIndex:888888,
                            icon:{
                                url:'http://digitaladmintrack.com/images/green_dot.png'
                            },

                            rotation:50,
                            id:{{ $device->id }},
                            name: "{{$device->name}}"
                        });
                                    @else
                                    var marker{{ $device->id }} = new google.maps.Marker({
                            position: myLatlng{{ $device->id }},
                            zIndex:888888,
                            icon:{
                                url:'http://digitaladmintrack.com/images/red_dot.png'
                            },

                            rotation:50,
                            id:{{ $device->id }},
                            name: "{{$device->name}}"
                        });
                        @endif


                          

                  boxText{{ $device->id }} = document.createElement("div");
                        boxText{{ $device->id }}.style.cssText = "background-color: #2e304a; color:white; padding: 10px; border-radius:10px";


                        //MOTOR PARA DESCRIPCION
                        @if($device->engine == 1)
                            <?php $motor = "<span class='engine".$device->id."  glyphicon glyphicon-record green' data-toggle='tooltip' data-placement='top' title='Unidad Encendida'></span>"; ?>
                        @endif 
                        @if($device->engine == 0)
                            <?php $motor = "<span class='engine".$device->id." glyphicon glyphicon-record red' data-toggle='tooltip' data-placement='top' title='Unidad Apagada'></span>"; ?> 
                        @endif 
                        //MOTOR

                         //*LABEL*//
                        labelText = '{{$device->name}}';
                        <?php $heading=''; ?>
                        @if($device->stop == 0)
                                    <?php $heading = '<span class="icon-arrow-circle-up move'. $device->id .' fa-rotate-'.$device->lastpacket->heading.' leicon green" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span>'; ?>
                                    @else
                                    <?php $heading = '<span class="icon-arrow-circle-up move'. $device->id .' fa-rotate-'. $device->lastpacket->heading .' leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span>'; ?>
                        @endif


                         
                        //CAJA
                         @if($device->stop ==1)

                         stopped_time = {{ $device->stop_time }}
                         

        if(stopped_time > 60){
            var hours = Math.floor( stopped_time / 60);          
        var minutes = stopped_time % 60;
        stopped_time = hours + ':' + minutes + ' horas'
        }else{
            stopped_time = stopped_time + ' minutos'
        }
                        boxText{{ $device->id }}.innerHTML = '{{$device->name}} - {!! $heading !!} '+ "<br>Fecha: {{ $device->lastpacket->updateTime }}<br> Tiempo Detenido: "+ stopped_time + "<br> Velocidad: {{ $device->lastpacket->speed }} k/h <br> Motor: {!! $motor !!} <br> <span class='getdirections'  onclick='getdirection({{ $device->lastpacket->lat }},{{$device->lastpacket->lng }})'>Obtener dirección</span>";

                        @else
                        boxText{{ $device->id }}.innerHTML ='{{$device->name}} - {!! $heading !!} '+ "<br>Fecha: {{ $device->lastpacket->updateTime }}<br> Velocidad: {{ $device->lastpacket->speed }} k/h <br> Motor: {!! $motor !!} <br> <span class='getdirections' onclick='getdirection({{ $device->lastpacket->lat }},{{$device->lastpacket->lng }})'>Obtener dirección</span>";

                        @endif

                               var myOptions = {
                             content: boxText{{ $device->id }}
                            ,disableAutoPan: false
                            ,maxWidth: 0
                            ,pixelOffset: new google.maps.Size(-140, 0)
                            ,zIndex: null
                            ,boxStyle: { 
                              background: "#2e304a"
                              ,width: "280px"
                              ,borderRadius:"6px"
                              ,color:'white'
                              ,padding:'10px'
                              ,position:"relative"
                             }
                            ,closeBoxMargin: "2px 2px 2px 2px"
                            ,closeBoxURL: "https://www.google.com/intl/en_us/mapfiles/close.gif"
                            ,infoBoxClearance: new google.maps.Size(1, 1)
                            ,isHidden: false
                            ,pane: "floatPane"
                            ,enableEventPropagation: false
                        };
                        var ib{{ $device->id }} = new InfoBox(myOptions);
                        //ib{{ $device->id }}.open(map, marker{{ $device->id }});


                        google.maps.event.addListener(marker{{ $device->id }}, "click", function (e) {
                            ib{{ $device->id }}.open(map, this);
                        });

                        shortName = '{{ $device->name }}'
                        if(shortName.length > 5){
                            console.log(' se paso {{ $device->name }}')
                            shortName = shortName.substring(0, 5);
                        }
                            @if($device->engine == 1)

                                    var labelText = '<img src="http://digitaladmintrack.com/images/truck_green_.png"> '+shortName+' {!! $heading !!} '
                                    @endif 
                                    @if($device->engine == 0)
                                    var labelText = '<img src="http://digitaladmintrack.com/images/red_truck_.png"> '+shortName+' {!! $heading !!} ' 
                            @endif 
                             

                            var myOptionsLabel = {
                                 content: labelText
                                ,boxStyle: {
                                    background: "#2e304a",
                                    borderRadius:"6px",
                                    color: 'white',
                                    zIndex: 999999,
                                  textAlign: "center",
                                  opacity:0.95,
                                  padding:'10px 10px 10px 0px',
                                  position:'absolute',
                                  top:'30px'
                                  ,fontSize: "8pt"
                                  ,width: "110px"
                                 }
                                ,disableAutoPan: true
                                ,pixelOffset: new google.maps.Size(-30, -58)
                                ,position: myLatlng{{ $device->id }}
                                ,closeBoxURL: ""
                                ,isHidden: false
                                ,pane: "mapPane"
                                ,enableEventPropagation: true
                            };

                            var ibLabel{{ $device->id }} = new InfoBox(myOptionsLabel);
                            ibLabel{{ $device->id }}.open(map, marker{{ $device->id }});
                        //*LABEL*//
                         var label{{ $device->id }} = new MarkerWithLabel({
                            position: myLatlng{{ $device->id }},

                            icon: " ",
                            labelContent: "<div   onclick='showinfo({{$device->id}})'><span class='glyphicon @if($device->dstate_id==1) movement  @endif  glyphicon-circle-arrow-up fa-rotate-{{$device->lastpacket->heading}}' aria-hidden='true'></span> {{$device->name}} @if($device->boxs_id != null) -> {{ $device->boxs->name }} @endif</div><div class='none windowinfo window{{$device->id}}'>Velocidad:**** <span >{{$device->lastpacket->speed }}</span></div>",
                            labelAnchor: new google.maps.Point(22, 0),
                            labelClass: "labels", // the CSS class for the label
                            labelStyle: {opacity: 0.75},
                            id:{{ $device->id }},
                            name: "{{$device->name}}"
                        });
                          mwl.push(label{{ $device->id }})
                   m.push(marker{{ $device->id }})


                   @endif

                 @endforeach 



                 var options = {
                imagePath: '/images/m'
            };

            var options2 = {
                imagePath: '/images/mA'
            };

            //var markerCluster = new MarkerClusterer(map, m, options);
            var markerCluster = new MarkerClusterer(map, m, {
              averageCenter: true,
              gridSize:30
            });

            // var markerClusterLbl = new MarkerClusterer(map, mwl, options2);
mo = []
           google.maps.event.addListener(markerCluster, "mouseover", function (c) {
             
              var centro = c.getCenter();
             

             var elcentro = centro + '<';
             console.log(elcentro)

             var result = elcentro.slice(1, -2);
             console.log(result)

             var res = result.split(",");
             
             lat = res[0];
             lng = res[1]

             myLatilng= new google.maps.LatLng(lat,lng);
              console.log(myLatilng)
              console.log("cuantos " + c.getSize());
              console.log("marcadores: " + c.getMarkers());
              names = '<button type="button" class="close closealo" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
              $.each(c.getMarkers(),function(index,value){
              
             
                names =  names + 'Equipo: <span style="color:white">'+ value.name + ' </span><br> ';

              })

               $('.content_devices').html(names)
               $('.content_devices').slideDown( "slow", function() {
    // Animation complete.
  });
  $('.closealo').click(function(){
    console.log('slo')
    $('.content_devices').slideUp( "slow", function() {
    // Animation complete.
  });
})
/*
  var letimer = setTimeout(function(){ $('.content_devices').slideUp( "slow", function() {
    // Animation complete.
  });  console.log('timer activadi')}, 5000); */
             
              
            });

    google.maps.event.addListener(markerCluster, "mouseout", function (c) {
              $('.content_devices').slideUp( "slow", function() {
    // Animation complete.
  });

             


            });


                 $('.showDevice').click(function(){
                    id=$(this).attr('ide');
                    if($(this).is(':checked')==true){
                       
                       $.each(m, function( index, value ) {

                if(value.id == id){ 
                    console.log()
                    m[index].setVisible(true)
                }
            })
                       $.each(mwl, function( index, value ) {

                if(value.id == id){ 
                    mwl[index].setVisible(true)
                }
            })

                    }else{

            $.each(m, function( index, value ) {

                if(value.id == id){ 
                    m[index].setVisible(false)
                }
            })

             $.each(mwl, function( index, value ) {
                
                if(value.id == id){ 
                    mwl[index].setVisible(false)
                }
            })
     
                        //marker.setVisible(false
                    }
                })

                 function getdirection(lati,langi){
            
                
                var latlng = {lat: lati, lng: langi};

                 geocoder.geocode({'location': latlng}, function(results, status) {
       
                     if (status === 'OK') {
                        if (results[1]) {
                          map.setZoom(11);
                          var marker = new google.maps.Marker({
                            position: latlng,
                            map: map
                          });
                          infowindow.setContent(results[1].formatted_address);
                          infowindow.open(map, marker);
                        } else {
                          window.alert('No results found');
                        }
                      } else {
                        window.alert('Geocoder failed due to: ' + status);
                      }

                 })
             }
               


                        function showinfo(id){ 
                            $('.window'+id).toggleClass('none')
                        }
                        var $log = $("#log");

                        function goto(){
                            $('.goto').click(function(){ 
                            map.setZoom(15);
                            map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                        })
                        }
                        $('.goto').click(function(){ 
                            map.setZoom(15);
                            map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                        })

                        function wait(ms){
                            var start = new Date().getTime();
                            var end = start;
                            while(end < start + ms) {
                                end = new Date().getTime();
                            }
                        }
                        function go(id,lat,lng,geofence,dstate_id,speed,device_name,heading,movement,status,EventCode,updateTime,stop_time,stop,odometro,previous_heading,odometro_total){
                            
                            //HEADING
                                $('.move'+id).removeClass('fa-rotate-'+previous_heading)
                                $('.move'+id).addClass('fa-rotate-'+heading)
                                $('.move'+id).addClass('ahora'+heading)
                            //HEADING
                            $('.odometro'+id).html(odometro)
                            if(stop==1){
                                //poner rojo
                                $('.move'+id).removeClass('green')
                                $('.move'+id).addClass('shutdown')
                                $('.move'+id).attr('data-original-title','Unidad detenida n')

                                // CAMBIAR ICONO EN MOVIMIENTO A VERDE

                              


                                $('.moveIcon'+id).attr('src','http://digitaladmintrack.com/images/red_truck_.png')
                                icon_move =  '<span class="icon-arrow-circle-up  leicon shutdown  fa-rotate-'+heading+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidad en Movimiento"></span>'
                           } 
                            if(stop==0){
                                //poner rojo
                                $('.move'+id).removeClass('shutdown')
                                $('.move'+id).addClass('green')
                                $('.move'+id).addClass('sepusoverde')
                                $('.move'+id).attr('data-original-title','Unidad en Movimiento')
                                $('.moveIcon'+id).attr('src','http://digitaladmintrack.com/images/truck_green_.png')
                                icon_move =  '<span class="icon-arrow-circle-up  leicon green  fa-rotate-'+heading+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidad en Movimiento"></span>'
                            }
                            $(".uptime"+id).timer('remove');
                            $(".uptime"+id).css('color','#6d6d6d');
                            console.log('timer'+id + ' removerlo')
                            $(".timer"+id).timer('remove');
                            $(".timer"+id).timer(); 
                            if(movement == true){
                                movement_class = 'movement'
                            }else{
                                movement_class='stop'
                            }
                            if(dstate_id == 1){
                                 
                                $( ".device_"+id ).addClass('msv flash animate')
                                 
                            }
                            if(dstate_id == 4){ 
                                $( ".device_"+id ).removeClass('msv flash animate')

                            }
                            $( ".device_"+id+ " a" ).attr('lat',lat)
                            $( ".device_"+id+ " a" ).attr('lng',lng)

                            //$.notify("nuevo paquete", "info");
                            akaname = 'marker'+id
                            buble = 'ib'+id
                             
                            lalabel = 'ibLabel'+id
     
                            if(stop == 1){

                            if(stop_time > 60){
        var hours = Math.floor( stop_time / 60);          
    var minutes = stop_time % 60;
    stopped_time = hours + ':' + minutes + ' horas'
    if(hours > 24){
        days = Math.floor( hours / 24); 
        var horas = hours % 24;
        stopped_time = days + ' días con ' + horas + ' horas';
    }
    }else{
        stopped_time = stop_time + ' minutos'
    }


                           this[buble].setContent(device_name + ' '+icon_move+ '<br> Fecha: '+updateTime+'<br> Tiempo Detenido--: '+stopped_time+' <br> Velocidad: '+speed+' K/h.<br> <span class="getdirections"  onclick="getdirection('+lat+','+lng+')">Obtener dirección</span>')
                        }else{
                           this[buble].setContent(device_name + ' '+icon_move+ '<br> Fecha: '+updateTime+'<br> Velocidad-: '+speed+' K/h.<br> <span class="getdirections"  onclick="getdirection('+lat+','+lng+')">Obtener dirección</span>') 
                        }

                        short_device_name = device_name
                        if(short_device_name.length > 5){
                            short_device_name = short_device_name.substring(0, 5);
                        }
                            if(stop == 0){
                                leimage = 'http://digitaladmintrack.com/images/truck_green_.png'
                                lalabelcontent = '<img src="http://digitaladmintrack.com/images/truck_green_.png"> ' + short_device_name + ' ' + icon_move;
                            }
                            if(stop == 1){
                                leimage = 'http://digitaladmintrack.com/images/red_truck_.png'
                                lalabelcontent = '<img src="http://digitaladmintrack.com/images/red_truck_.png"> ' + short_device_name + ' ' + icon_move;
                            }
                            
                            
                               
                            if(EventCode == 20){
                                $('.engine'+id).removeClass('green')
                                $('.engine'+id).addClass('shutdown')
                                $('.engine'+id).attr('data-original-title','Unidad Apagada')
                                elengine = '<span class="engine'+id+' glyphicon glyphicon-record shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Apagada *"></span>'
                                lalabelcontent ='<img src="'+leimage+'">' + short_device_name + '<span class="engine'+id+' glyphicon glyphicon-record shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>'
                                 
                            }
     
                            if(EventCode == 21){
                                $('.engine'+id).removeClass('shutdown')
                                $('.engine'+id).addClass('green') 
                                $('.engine'+id).attr('data-original-title','Unidad Encendida')
                                elengine = '*<span class="engine'+id+' glyphicon glyphicon-record green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida *"></span>'
                                lalabelcontent = '<img src="'+leimage+'">' + short_device_name  + '<span class="engine'+id+' glyphicon glyphicon-record green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>'
                                
                            } 
                            this[lalabel].setContent(lalabelcontent)

                            //
                            labelname = 'label'+id
                            myLatlng = new google.maps.LatLng(lat, lng); 
                            this[labelname].setPosition( myLatlng );
                            this[labelname].labelContent = "---<div   onclick='showinfo("+id+")'><span class='glyphicon glyphicon-circle-arrow-up "+ movement_class +" fa-rotate-"+heading+"' aria-hidden='true'></span>"+device_name+" namedevice</div><div class='none windowinfo window"+id+"'>Fecha: "+updateTime+" <br>Velocidad: "+speed+"<br> <span class='getdirections' onclick='getdirection("+lat+","+lng+")'>Obtener dirección</span></div>";
                            this[labelname].label.setContent();

                            this[akaname].setDuration(1000)
                            this[akaname].setEasing('linear');
                            this[akaname].setPosition(myLatlng);
                            if(stop == 0){
                                this[akaname].setIcon('http://digitaladmintrack.com/images/green_dot.png');
                            }else{
                                this[akaname].setIcon('http://digitaladmintrack.com/images/red_dot.png');
                            }
                            
                            var o  = odometro_total / 1000;
                           	 b = parseFloat(o).toFixed(1);
                            $('.speed'+id).attr('data-original-title',speed + ' km/h. | ' + b + ' kms')
                            if(speed < 100){
                                $('.speed'+id).removeClass('red')
                                $('.speed'+id).addClass('shutdown')

                            }
                            if(speed >= 100){
                                $('.speed'+id).removeClass('shutdown')
                                $('.speed'+id).addClass('red')

                            }
                            refresh(id)
                            $.ajax({
                                url:'packet/refresh',
                                type:'POST',
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: { device_id: id ,geofence:geofence},
                                success: function(r){ 
                                    
                                    $('.device_timer_'+id).html(r['time'])
                                },
                                error: function(data){
                                    var errors = data.responseJSON;
                                    
                                }
                            })
                        }
                        function refresh(id){ 
                            //ANTES
                            $( ".device_"+id ).css('backgound-color','red')
                            $( ".device_"+id ).animate({
                                opacity: 0.1,
                            }, 1000 );

                            setTimeout(function(){
                                //DEPUES
                                $( ".device_"+id ).css('backgound-color','white')
                                $( ".device_"+id ).animate({
                                    opacity: 1,
                                }, 1500 );
                            }, 2000);
                        }

                        var socket = io(':3000');
                        //var socket = io(':3004');
                        socket.on("message<?php echo Auth::user()->client_id  ?>", function(data){
                      
                         
                            go(data['device_id'],data['lat'], data['lng'],data['geofence'],data['dstate_id'],data['Speed'],data['device_name'],data['Heading'],data['movement'],data['status'],data['EventCode'],data['updateTime'],data['stop_time'],data['stop'],data['odometro'],data['previous_heading'],data['odometro_total'])
                        })

                        socket.on("event<?php echo Auth::user()->client_id  ?>", function(data){
                       
                            evento = data['response'][0];
                            name = data['response'][1];
                            ide = data['response'][2];



                            //DESBLOQUEAR

                            if(evento == 116){

                                $('.block'+ide).removeClass('locking')
                                $('.block'+ide).addClass('locked')
                                $('.block'+ide).attr('code','!R3,17,10')
                                $('.block'+ide).attr('des','desbloquear')
                                $('.block'+ide).attr('title','Desbloquear unidad')
                                $('.block'+ide).attr('step','2')
                                $('.block'+ide).html( '<span class="glyphicon glyphicon-stop eicon" aria-hidden="true"></span> ')
                               
                            }

                            if(evento == 118){
                                $('.block'+ide).removeClass('locking')
                                $('.block'+ide).removeClass('locked')
                                $('.block'+ide).addClass('unlock')
                                $('.block'+ide).attr('title','Bloquear unidad')
                                $('.block'+ide).attr('des','bloquear')
                                $('.block'+ide).attr('code','!R3,17,8')
                                $('.block'+ide).attr('step','1')
                                $('.block'+ide).html( '<span class="glyphicon glyphicon-stop eicon" aria-hidden="true"></span> ')
                               
                            }

                            if(evento == 68){
                                //DESCONEXION
                               $('.unplugged'+ide).show()
                            }


                            if(evento == 61){
                                //DESCONEXION
                               $('.panic'+ide).show()
                            }

                            if(evento == 60){
                                //DESCONEXION
                               $('.panic'+ide).show()
                            }

                            if(evento == 69){
                                //CONEXION
                                $('.unplugged'+ide).hide()
                               
                            }




                        })

                        socket.on("geocerca<?php echo Auth::user()->client_id  ?>", function(data){
     
                            ide = data['response'][0];
                            
                            $.ajax({
                                url:'/geofences/get',
                                type:'POST',
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: { id: ide },
                                success: function(r){ 
                                    device_name = data['response'][1];
                                    status = data['response'][2];
                                    if(status == 'in'){
                                        status_desc = 'entro a'
                                    }else if (status== 'out') {
                                        status_desc = 'salio de'
                                    }
                                    if(r.type=='circle'){
                                        llat = r.lat;
                                        llng = r.lng;
                                    }else{
                                        poly_data = r.poly_data
                                         
                                        poly_data = JSON.parse(poly_data);
                                        llat = poly_data[0].lat;
                                        llng = poly_data[0].lng;
                                    }
                                    
                  
                                    
                                  $.notify.addStyle('happyblues', {
                                      html: "<div><span data-notify-html/></div>",
                                      classes: {
                                        base: {
                                          "white-space": "nowrap",
                                          "background-color": "#dedede",
                                          "padding": "10px",
                                          "height":'35px'
                                        },
                                        corner: {
                                           
                                          "margin":'10px'
                                        },
                                        superblues: {
                                          "color": "white",
                                          "background-color": "#1991eb"
                                        }
                                      }
                                    });  
                                  $.notify(device_name +' '+status_desc+ ' <a class=" goto gotoa " lat="'+llat+'" lng = "'+llng+'" >'+ r.name + '</a>', {
      style: 'happyblues',
      className: 'superblues',
      clickToHide: false,
      autoHideDelay: 5000,
      position: 'bottom right'
    });
                             
                            $('.goto').click(function(){ 
                            map.setZoom(15);
                            map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                        }) 

                                },
                                error: function(data){
                                    var errors = data.responseJSON;
                                    console.log(errors )
                                }
                            })

                        })

                        
                        
                        socket.on("carga_start<?php echo Auth::user()->client_id  ?>", function(data){
                             console.log('CAAAAAARGA START')
                             console.log(data)
                            $('.device_'+data).removeClass('bg-orange')
                            $('.device_'+data).addClass('bg-green') 
                            $('#state_'+data).html('CARGANDO')
                            $.notify("COMENZO carga", "info");
                        })
                        socket.on("travel_start<?php echo Auth::user()->client_id  ?>", function(data){
                            
                            $('.device_'+data).removeClass('bg-green')
                            $('.device_'+data).addClass('bg-blue')
                            $('#state_'+data).html('EN RUTA')
                             
                            $.notify("COMENZO VIAJE", "info");
                        })
                        socket.on("descarga_start<?php echo Auth::user()->client_id  ?>", function(data){
                             
                            $('.device_'+data).removeClass('bg-blue')
                            $('.device_'+data).addClass('bg-purple') 
                            $('#state_'+data).html('DESCARGANDO')
                            $.notify("COMENZO descarga", "info");
                        })
                        socket.on("travel_end<?php echo Auth::user()->client_id  ?>", function(data){
                            $('.device_'+data).removeClass('bg-purple')
                            $( ".device_"+data ).clone().appendTo( ".devices-right" );
                            $( ".devices-left .device_"+data ).hide() 
                            $.notify("TERMINO VIAJE", "info");
                        })

                        resizeMap()
                        r = false
                        $('.resize-button').click(function(){
                            resizeFooter()
                            resizeMap()
                        })
                        function  resizeFooter(){
                            if(r == false){
                                b = $('body').height()
                                b = b/2
                                r = true
                            }else{ 
                                b = 100
                                r = false
                            }
                            $('#footer').css('height',b+'px')
                        }


                        </script>
                        <!-- Scripts -->
                        <script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
                        @endsection
                        <style>
                        .panicMap{
                            width: 100%;
                            height: 300px;
                        }
                        .selectedone .butonSelect{
                            color: white
                        }
                     
                        .movement{
                            color: green;
                        }
                        .gotoa {
    text-decoration: underline;
    color: #ffffff;
}
                       .notifyjs-happyblues-superblues {
    color: white;
    padding-top: 20px;
    background-color: #1991eb;
}
      .notifyjs-happyblues-superblues {
    color: white;
    border-radius: 24px;
    background-color: #3fb6ff;
}
                        </style>