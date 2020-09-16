
@extends('layouts.master2')
    @section('content')
 
    <div class="row">
        <div class="col-md-3 visible-xs devices_mobile">
            <input type="text" id="search_mobile" style="width:100%" placeholder="  Buscar Unidad"></input>

            @foreach($devices  as $device)
            @if($device->status==0)
      @if(isset($device->lastpacket->lat ))
<div class="mobile-device device_{{ $device->id }} @if($device->dstate_id==1)  @endif" name="{{ $device->name }}">
<table class="table">
    <tr>
        <td style="width: 50px">

    <a class="white goto f mb0" lat="{{ $device->lastpacket->lat }}"
                    lng = "{{ $device->lastpacket->lng }}"> {{ str_limit(ucfirst($device->name), $limit = 15, $end = '...') }} </a>
        </td>
        <td style="width: 70px">
             <?php  if( $device->status($device->lastpacket) > 60){
                echo $device->statusForHumans($device->lastpacket);
            }else{
                ?><div class="timer_design timer{{ $device->id }}"></div><?php
            }   ?>
        </td>
        <td style="width: 40px">
             @if($device->engine == 1)
            <span class="engine{{ $device->id }}  icon-engine leiconM green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>
            @endif
            @if($device->engine === 0)
            <span class="engine{{ $device->id }} icon-engine leiconM shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Apagada"></span>
            @endif

        </td>
        <td style="width: 40px">
            @if($device->unplugged == 0)

            @if($device->stop == 0)
            {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leiconM green" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span>
            @else
            {{ $device->speed  }}<span class="icon-arrow-circle-up move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leiconM shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span>
            @endif
            @endif
        </td>
        <td>
            <span class="speedMobile  speed_{{ $device->id }}">{{ $device->lastpacket->speed }} km/h </span>
        </td>
        <td>
            {!! $device->battery_alarm($config->battery_alarm,$device->lastpacket->power_bat) !!}
            {!! $device->rssi_alarm($config->rssi_alarm,$device->lastpacket->rssi) !!}
        </td>
    </tr>
</table>









        </div>





    @endif
    @endif
            @endforeach
        </div>
        <div class="col-md-3 devices-left hidden-xs">
          <div class="content_devices none"></div>


    <p class="asign">UNIDADESd <input type="checkbox" class="showDevices" checked></p>
    <div style="text-align: center;"><input type="text" id="search_right" style="width:80%" placeholder="  Buscar Unidad"></input></div>

    <span class="rightTop"></span>
     @foreach($groups as $groupname => $arraydevs)
        @foreach($arraydevs as $idgroup => $devicess)
      <div class="gnames grupo{{ $idgroup }}">
<div class="container-group-title"><span class="gnamestyle">{{ $groupname }}</span>
<div class="dropdown" style="float: right;">

  <span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    @if($idgroup != 0)<span class="glyphicon glyphicon-option-horizontal  engra" aria-hidden="true"></span>@endif

  </span>

  <span class="glyphicon glyphicon-menu-hamburger toogleg{{ $idgroup }}" groupid="{{ $idgroup }}" aria-hidden="true"></span>

   <ul class=" dropdown-menu dropdown-menu3" aria-labelledby="dropdownMenu1">
    <li><span style="color: black;
    margin-left: 12px;" class="deletegroup" type="1" name="{{ $groupname }}" groupid="{{ $idgroup }}" user_id="{{ Auth::user()->id }}">Eliminar grupo</span></li>

  </ul>
</div>






</div>
<div class="  container-devices-group{{ $idgroup }}" >


    @foreach($devicess  as $device)
    @if($device->status==0)
    <?php $devices_availables++ ?>


    @if(isset($device->lastpacket->lat ))
    <div class="device device-off2 device_{{ $device->id }} device_{{ $idgroup }}_{{ $device->id }} devicedesktop{{ $device->id }}  @if($device->dstate_id==1) @endif" name="{{ $device->name }}" group_id="{{ $idgroup }}">

<div class="todiv" >
    <div class="byside" >

        <div class="checkbox">
  <label>
   <input type="checkbox"class="showDevice" ide="{{ $device->id }}" checked>
   <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>

   </label>
</div>

                <a class="white goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
                    lng = "{{ $device->lastpacket->lng }}" style="float:left">




                    {{ str_limit(ucfirst($device->name), $limit = 13, $end = '.') }} </a>
    </div>
    <div class="byside" style="text-align: right;"><div class="dropdown">
  <span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <span class="glyphicon glyphicon-cog engrane" aria-hidden="true"></span>

  </span>
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
   <ul class=" dropdown-menu dropdown-menu2" aria-labelledby="dropdownMenu1">
    <li><a href="#">
        <span class="  openmodal" group_id="{{ $idgroup }}" type="1" device_id="{{ $device->id }}" user_id="{{ Auth::user()->id }}" data-toggle="modal" class="" data-target=".myModalgroups{{ $device->id }}_{{ $idgroup }}">Agregar a un grupo</span></a></li>
  </ul>
</div> </div>
    <div class="clear"></div>




<div class="clear"></div>
</div>
<div class="todiv">
        <div class="ttext">
                        <p class="text11 timerText" >
                        <?php  if( $device->status($device->lastpacket) > 60){
                            echo $device->statusForHumans($device->lastpacket);
                        }else{
                            ?><span class="timer{{ $device->id }}"></span><?php
                        }   ?>
                        </p>
                    </div>



                     <div class="icon iconop ">
                          <span class=" glyphicon white glyphicon-envelope  openchat"  device_id="{{ $device->id }}" user_id="{{ Auth::user()->id }}"  ></span>


                    </div>

                    <div class="icon speedicon{{ $device->id }} @if( $device->lastpacket->speed > 100) iconred @endif">
                    @if( $device->lastpacket->speed > 100)
                        <span class="icon-speedometer leicon white  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ $device->lastpacket->odometro_total/1000 }}"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                        @else
                        <span class="icon-speedometer leicon shutdown  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ number_format($device->lastpacket->odometro_total/1000, 1, '.', ',') }} kms"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                        @endif
                    </div>
                    <div class="icon moveiconl{{ $device->id }}  @if($device->stop == 0) iconblue @else  @endif" >


                        @if($device->stop == 0)
                        {{ $device->speed  }}<span class="icon-arrow-circle-up acomodo move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon white" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span>
                        @else
                        {{ $device->speed  }}<span class="icon-arrow-circle-up acomodo move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span>
                        @endif



                    </div>
                    <div class="icon engineicon{{ $device->id }} @if($device->engine == 1)icongreen @endif">
                        @if($device->engine == 1)
                        <span class="engine{{ $device->id }}  icon-engine leicon white" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>
                        @endif
                        @if($device->engine === 0)
                        <span class="engine{{ $device->id }} icon-engine leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Apagada"></span>
                        @endif
                    </div>
                    {!! $device->battery_alarm_v2($config->battery_alarm,$device->lastpacket->power_bat) !!}
                    {!! $device->rssi_alarm_v2($config->rssi_alarm,$device->lastpacket->rssi) !!}

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

<div class="icon iconred unplugged{{ $device->id }} @if($device->unplugged == 0)   none @endif">


    <span data-toggle="tooltip" data-placement="top" title="Equipo desconectado"  class="glyphicon leicon unplugged{{ $device->id }} icon-plug white  @if($device->unplugged == 0)   none @endif " aria-hidden="true"></span>

                    </div>









                    <div class="clear"></div>
</div>






    </div>


<div class="modal myModalgroups{{ $device->id }}_{{ $idgroup }} fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-headerg">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Guardar unidad {{ $device->name }} en</h4>
      </div>
      <div class="modal-body">

        <div class="grouplist"></div>
      </div>
      <div class="modal-footer">
        <div class="btng"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo grupo de unidades</div>
        <div class="none formgroup">
            <span class="alertname none ">EL nombre del grupo no puede quedar vacío</span>
            <input type="text" class="gname{{ $device->id }} sgname" placeholder="Escribe el nombre del grupo" name="">
            <button user_id="{{ Auth::user()->id }}" device_id="{{ $device->id }}" fromgroup="" type="1" class="btn btn-primary btn-saveg saveg{{ $device->id }}">Crear</button>
        </div>
      </div>
    </div>
  </div>
</div>

@else
<!--EQUIPO SIN PAQUETES-->
<div class="device device-off2" name="{{ $device->name }}">
    <p style="color:grey">{{ ucfirst($device->name) }} Equipo nuevo. </p>
</div>


@endif
@endif

@endforeach
</div>
@endforeach
</div>
@endforeach
<span id="rightBottom"></span>
@if($devices_availables==0)
<p style="padding: 10px; text-align: center; color: grey;">No tienes equipos disponibles</p>
@endif
<div style="clear:both"></div>
</div>
<input id="pac-input" class="controls" type="text" placeholder="Buscar direcciones">
<div   id="map" style="float:right">

</div>
<div   id="mensajes" style="float:right">

</div>

<div id="el" class="col-md-3 devices-right s-left hidden-xs">
    <p class="asign">CAJAS <input type="checkbox" class="showCajas" checked></p>
    <div style="text-align: center;"><input type="text" id="search_left" style="width:80%" placeholder="  Buscar Caja"></input></div>
    <span class="rightTop"></span>
    @foreach($groups_cajas as $groupname => $arraydevs)
        @foreach($arraydevs as $idgroup => $devicess)
      <div class="gnamescajas grupo{{ $idgroup }}">
<div class="container-group-title"><span class="gnamestyle">{{ $groupname }}</span>
<div class="dropdown" style="float: right;">

  <span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    @if($idgroup != 0)<span class="glyphicon glyphicon-option-horizontal  engra" aria-hidden="true"></span>@endif

  </span>

  <span class="glyphicon glyphicon-menu-hamburger toogleg{{ $idgroup }}" groupid="{{ $idgroup }}" aria-hidden="true"></span>

   <ul class=" dropdown-menu dropdown-menu3" aria-labelledby="dropdownMenu1">
    <li><span style="color: black;
    margin-left: 12px;" class="deletegroup" type="2" name="{{ $groupname }}" groupid="{{ $idgroup }}" user_id="{{ Auth::user()->id }}">Eliminar grupo</span></li>

  </ul>
</div>






</div>
<div class="  container-devices-group{{ $idgroup }}" >


    @foreach($devicess  as $device)
    @if($device->status==0)
    <?php $devices_availables++ ?>


    @if(isset($device->lastpacket->lat ))
    <div class="device device-off2 device_{{ $device->id }} device_{{ $idgroup }}_{{ $device->id }} devicedesktop{{ $device->id }}  @if($device->dstate_id==1) @endif" name="{{ $device->name }}" group_id="{{ $idgroup }}">

<div class="todiv" >
    <div class="byside" >

        <div class="checkbox">
  <label>
   <input type="checkbox"class="showDevice" ide="{{ $device->id }}" checked>
   <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>

   </label>
</div>

                <a class="white goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
                    lng = "{{ $device->lastpacket->lng }}" style="float:left">




                    {{ str_limit(ucfirst($device->name), $limit = 15, $end = '...') }} </a>
    </div>
    <div class="byside" style="text-align: right;"><div class="dropdown">
  <span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <span class="glyphicon glyphicon-cog engrane" aria-hidden="true"></span>











  </span>









  <span  data-toggle="modal" data-target="#myModalEnganche{{ $device->id }}"  name="{{ $device->name }}" ide="{{ $device->id }}" class="panic{{ $device->id }} glyphicon  icon-stop red enganchemodal   " aria-hidden="true"></span>
                   <!-- Button trigger modal -->


                   <!-- Modal -->
                   <div class="modal fade" id="myModalEnganche{{ $device->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content ">
                          <div class="modal-header">
                            <div id="engMap{{ $device->id }}" class="panicMap"></div>

                        </div>
                        <div class="modal-body ">

                            <div class="col-md-12" style="text-align:left" id="enghtml{{ $device->id }}">
                                 
                            </div>
                             



                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-blue" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
   <ul class=" dropdown-menu dropdown-menu2" aria-labelledby="dropdownMenu1">
    <li><a href="#">
        <span class="  openmodal" group_id="{{ $idgroup }}" device_id="{{ $device->id }}" type="2" user_id="{{ Auth::user()->id }}" data-toggle="modal" class="" data-target=".myModalgroups{{ $device->id }}_{{ $idgroup }}">Agregar a un grupo</span></a></li>
  </ul>
</div> </div>
    <div class="clear"></div>




<div class="clear"></div>
</div>
<div class="todiv">
        <div class="ttext">
                        <p class="text11 timerText" >
                        <?php  if( $device->status($device->lastpacket) > 60){
                            echo $device->statusForHumans($device->lastpacket);
                        }else{
                            ?><span class="timer{{ $device->id }}"></span><?php
                        }   ?>
                        </p>
                    </div>



                     <div class="icon iconop ">
                          <span class=" glyphicon white glyphicon-envelope openchat "  device_id="{{ $device->id }}" user_id="{{ Auth::user()->id }}" data-toggle="modal" class="" data-target=".myModalmensaje{{ $device->id }}"></span>


                    </div>

                    <div class="icon speedicon{{ $device->id }} @if( $device->lastpacket->speed > 100) iconred @endif">
                    @if( $device->lastpacket->speed > 100)
                        <span class="icon-speedometer leicon white  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ $device->lastpacket->odometro_total/1000 }}"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                        @else
                        <span class="icon-speedometer leicon shutdown  speed{{ $device->id }}" data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }} km/h | {{ number_format($device->lastpacket->odometro_total/1000, 1, '.', ',') }} kms"></span> <!--<span class="red speed{{ $device->id }}"> {{ $device->lastpacket->speed }} km/h</span>-->
                        @endif
                    </div>
                    <div class="icon moveiconl{{ $device->id }}  @if($device->stop == 0) iconblue @else  @endif" >


                        @if($device->stop == 0)
                        {{ $device->speed  }}<span class="icon-arrow-circle-up acomodo move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon white" data-toggle="tooltip" data-placement="top" title="Unidad en movimiento"></span>
                        @else
                        {{ $device->speed  }}<span class="icon-arrow-circle-up acomodo move{{ $device->id }} fa-rotate-{{ $device->lastpacket->heading }} leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span>
                        @endif



                    </div>
                    <div class="icon engineicon{{ $device->id }} @if($device->engine == 1)icongreen @endif">
                        @if($device->engine == 1)
                        <span class="engine{{ $device->id }}  icon-engine leicon white" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>
                        @endif
                        @if($device->engine === 0)
                        <span class="engine{{ $device->id }} icon-engine leicon shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Apagada"></span>
                        @endif
                    </div>
                    {!! $device->battery_alarm_v2($config->battery_alarm,$device->lastpacket->power_bat) !!}
                    {!! $device->rssi_alarm_v2($config->rssi_alarm,$device->lastpacket->rssi) !!}

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

<div class="icon iconred unplugged{{ $device->id }} @if($device->unplugged == 0)   none @endif">


    <span data-toggle="tooltip" data-placement="top" title="Equipo desconectado"  class="glyphicon leicon unplugged{{ $device->id }} icon-plug white  @if($device->unplugged == 0)   none @endif " aria-hidden="true"></span>

                    </div>









                    <div class="clear"></div>
</div>






    </div>


<div class="modal myModalgroups{{ $device->id }}_{{ $idgroup }} fade" id="" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-headerg">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Guardar unidad {{ $device->name }} en</h4>
      </div>
      <div class="modal-body">

        <div class="grouplist"></div>
      </div>
      <div class="modal-footer">
        <div class="btng"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo grupo de unidades</div>
        <div class="none formgroup">
            <span class="alertname none ">EL nombre del grupo no puede quedar vacío</span>
            <input type="text" class="gname{{ $device->id }} sgname" placeholder="Escribe el nombre del grupo" name="">
            <button user_id="{{ Auth::user()->id }}" device_id="{{ $device->id }}" fromgroup="" type="2" class="btn btn-primary btn-saveg saveg{{ $device->id }}">Crear</button>
        </div>
      </div>
    </div>
  </div>
</div>


@else
<!--EQUIPO SIN PAQUETES-->
<div class="device device-off2" name="{{ $device->name }}">
    <p style="color:grey">{{ ucfirst($device->name) }} Equipo nuevo. </p>
</div>


@endif
@endif

@endforeach
</div>
@endforeach
</div>
@endforeach
<span id="rightBottom"></span>
@if($devices_availables==0)
<p style="padding: 10px; text-align: center; color: grey;">No tienes equipos disponibles</p>
@endif
<div style="clear:both"></div>
</div>

<style>
    .badge-notify-p {
    font-size: 8px !important;
}
    .content_devices{
        background: white;
        border: 1px solid #9e9e9e;
    }
    .icon{
        height: 19px;
    }
    .acomodo {
    display: flex;
}
.navbar-default {
    background-color: #161616;
    border-bottom-color: #cdcdcd;
}
.navbar-default .navbar-nav>li>a {
    color: #646464;
    text-transform: uppercase;
    font-weight: bolder;
    font-size: 10px;
}
</style>


@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw&libraries=drawing,places" type="text/javascript"></script>
<script src="/js/masterv2.js"></script>

 @foreach($groups as $groupname => $arraydevs)
        @foreach($arraydevs as $idgroup => $devicess)
    <script type="text/javascript">
     $('.toogleg{{ $idgroup }}').click(function(){
        id = $(this).attr('groupid')
        console.log(id)
        $( ".container-devices-group{{ $idgroup }}").slideToggle( "slow" );
    })
</script>
@endforeach
@endforeach

@foreach($groups_cajas as $groupname => $arraydevs)
        @foreach($arraydevs as $idgroup => $devicess)
    <script type="text/javascript">
     $('.toogleg{{ $idgroup }}').click(function(){
        id = $(this).attr('groupid')
        console.log(id)
        $( ".container-devices-group{{ $idgroup }}").slideToggle( "slow" );
    })
</script>
@endforeach
@endforeach

<script>
  $('.jewelButton').click(function(){
    id = $(this).attr('ide');
    $('.badge-notify-p-count').hide();
    $('.comment-icon').removeClass('blue')
    $.ajax({
        url:'/user/jewel',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id:id },
        success: function(r){
            console.log(r)
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})
function closeconv(){
    $('.closeconv').click(function(){
        $('#mensajes').html('')
    })
}

$('.openchat').click(function(){
                device_id = $(this).attr('device_id');
                user_id = $(this).attr('user_id');

    $.ajax({
                    url:'/openchat',
                    type:'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {   device_id:device_id, user_id:user_id},
                    success: function(r){

                      $('#mensajes').html(r)
                     $('.contmensajes').animate({scrollTop: 200});
                      closeconv()
                      bcoment()
                    },
                    error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
})
$(".notification .nlink").on("click",function(e){

                ide = $(this).attr('ide');
                device_id = $(this).attr('device_id');
                user_id = $(this).attr('user_id');
                link = $(this).attr('to');
                nid = $(this).attr('nid')

                console.log(ide)
                console.log('que pedo')
                $.ajax({
                    url:'/message/notification_read',
                    type:'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { id:ide , device_id:device_id, user_id:user_id},
                    success: function(r){

                      $('#mensajes').html(r)
                      $('.contmensajes').animate({scrollTop: 200});
                      $('.notification'+nid).addClass('readed')

                      $('.notifications').addClass('none')
                      $('.pyramid').addClass('none')
                      bcoment()
                      closeconv()
                    },
                    error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
                return false

             });

    $('.deletegroup').click(function(){
        gid = $(this).attr('groupid')
        name = $(this).attr('name')
        user_id = $(this).attr('user_id')
        type = $(this).attr('type')
        console.log(gid)
        $.confirm({
            title: '',
            content: '<label>¿Deseas eliminar el grupo '+ name +'?</label>' ,
            buttons: {
                confirm: function () {
                    $.ajax({
                        url:'/delete/group',
                        type:'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { id: gid ,user_id:user_id},
                        success: function(success){
                            console.log(success)
                            // devices = JSON.parse(success)
                           // console.log(devices)

                            $.each(success,function(device_id,b){
                                console.log(device_id + ' - ' + b )

                                dev = $('.devicedesktop'+device_id+':eq(0)').clone();



                                $(dev[0]).addClass('device_0_'+device_id)

                                fromgroup = $(dev[0]).attr('group_id')
                                $(dev[0]).removeClass('device_'+fromgroup+'_'+device_id)
                                if(type ==1){
                                  $('.container-devices-group0').append(dev);
                                }else{
                                  $('.container-devices-group1').append(dev);
                                }



                            })
                            $('.grupo'+gid).remove()


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
    $('.toogleg').click(function(){
        id = $(this).attr('groupid')
        console.log(id)
        $( ".container-devices-group"+id ).slideToggle( "slow" );
    })
$('.btng').click(function(){
    $('.btng').hide()
    $('.formgroup').show()
    console.log('st')
})
$('.openmodal').click(function(){
    $('.alertname').hide()
    $('.formgroup').hide()
    $('.btng').show()
    user_id = $(this).attr('user_id')
    device_id = $(this).attr('device_id')
    fromgroup = $(this).attr('group_id')
    type = $(this).attr('type')
    console.log('traer grupos' + user_id + device_id + fromgroup + 'type' + type)
    $.ajax({
            url:'/get/groups',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { user_id: user_id,device_id:device_id,type:type },
            success: function(groups){
                console.log(groups)

                $('.grouplist').html(groups)
                $('.saveg'+device_id).attr('fromgroup',fromgroup)
                addfunctions(device_id,b.id,user_id,fromgroup,type)
                }
            })
    console.log('termino')
})

function addfunctions(device_id,group_id,user_id,fromgroup,type){

    $('.addToGroup').change(function(){
        user_id = $(this).attr('user_id')
    device_id = $(this).attr('device_id')
    group_id =  $(this).attr('group_id')
    groupname = $(this).attr('groupname')

        console.log(group_id)
        console.log('agregar al grupo')
        esta = $(this).is(':checked')
        console.log(esta)
        if(esta == true){
            // agregar
            $.ajax({
            url:'/addto/group',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { user_id: user_id, device_id: device_id, group_id: group_id },
            success: function(groups){
                movetogroup(device_id,group_id,fromgroup,type);
                console.log(groups)
            }
            })
        }else{
            //retirar
            $.ajax({
            url:'/removeto/group',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { user_id: user_id, device_id: device_id, group_id: group_id },
            success: function(groups){
                console.log(groups)
                groups = JSON.parse(groups)
                console.log(groups['status'] + ' status')
                console.log(groups.status + ' status')


                deletefromgroup(device_id,group_id,groups.status);
            }
            })
        }
    })
}
function movetogroup(device_id,group_id,fromgroup,type){
    console.log('add to ' + group_id + ' - ' + fromgroup + ' - ' +  device_id)
    // dev = $('.device_'+fromgroup+'_'+device_id).clone();

    dev = $('.devicedesktop'+device_id+':eq(0)').clone();


    if(type==1){
        dd = 0
    }else{
        dd=1
    }
    if(fromgroup == dd){
        console.log('.device_'+fromgroup+'_'+device_id)
        $('.device_'+fromgroup+'_'+device_id).remove();
    }

    $(dev[0]).addClass('device_'+group_id+'_'+device_id)
    $(dev[0]).removeClass('device_'+fromgroup+'_'+device_id)

    $('.container-devices-group'+group_id).append(dev);



    ('.device_'+group_id+'_'+device_id)
}

function deletefromgroup(device_id,group_id,status){
    dev = $('.grupo'+group_id +' .devicedesktop'+device_id).clone()
    if(status == 0){
        $('.grupo0').append(dev)
    }
    $('.grupo'+group_id +' .devicedesktop'+device_id).remove()
}
$('.btn-saveg').click(function(){
    user_id = $(this).attr('user_id')
    device_id = $(this).attr('device_id')
    fromgroup = $(this).attr('fromgroup')
    type = $(this).attr('type')
    name = $('.gname'+device_id).val()
  console.log(name)
    if(name == ''){
        $('.alertname').show()
        return false
    }
    console.log(user_id,device_id,name,type)
      $.ajax({
            url:'/insert/group',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { user_id: user_id, device_id: device_id, name: name,type:type },
            success: function(groups){
                console.log(groups.id)
              if(type == 1){
                creategroup(name,device_id,groups.id,fromgroup,user_id,type)
              }else{
                creategroupcajas(name,device_id,groups.id,fromgroup,user_id,type)
              }

                $('.myModalgroups'+device_id+'_'+fromgroup).modal('hide')
                }
            })

})

function creategroup(name,device_id,group_id,fromgroup,user_id){
    console.log(name)
    groupnumber = $('.gnames').length;
    lastgroup = groupnumber-1;
    dev = $('.devicedesktop'+device_id+':eq(0)').clone();

    $(dev[0]).addClass('device_'+group_id+'_'+device_id)
    $(dev[0]).removeClass('device_'+fromgroup+'_'+device_id)

    if(fromgroup == 0){
        console.log('.device_'+fromgroup+'_'+device_id)
        $('.device_'+fromgroup+'_'+device_id).remove();
    }

    console.log('.devicedesktop'+device_id+':eq(0)' + ' agregar el device_id ' + device_id + ' en el grupoid ' + group_id)
   $('.gnames:eq('+lastgroup+')').before('<div class="gnames grupo'+group_id+'"><div class="container-group-title"><span class="gnamestyle">'+name+'</span><div class="dropdown" style="float: right;"><span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-option-horizontal  engra" aria-hidden="true"></span></span><span class="glyphicon glyphicon-menu-hamburger toogleg'+group_id+'" groupid="'+group_id+'" aria-hidden="true"></span><ul class=" dropdown-menu dropdown-menu3" aria-labelledby="dropdownMenu1"><li><span style="color: black; margin-left: 12px;" class="deletegroup" type="1" name="'+name+'" groupid="'+group_id+'" user_id="'+user_id+'">Eliminar grupo</span></li></ul></div></div></div><div class="container-devices-group'+group_id+'"></div>')

   $('.container-devices-group'+group_id).append(dev);

   $('.toogleg'+group_id).click(function(){
        id = $(this).attr('groupid')
        console.log(id)
        $( ".container-devices-group"+id ).slideToggle( "slow" );
    })


}

function creategroupcajas(name,device_id,group_id,fromgroup,user_id){

    groupnumber = $('.gnamescajas').length;
    lastgroup = groupnumber-1;
    dev = $('.devicedesktop'+device_id+':eq(0)').clone();

    $(dev[0]).addClass('device_'+group_id+'_'+device_id)
    $(dev[0]).removeClass('device_'+fromgroup+'_'+device_id)

    if(fromgroup == 1){
        console.log('.device_'+fromgroup+'_'+device_id)
        $('.device_'+fromgroup+'_'+device_id).remove();
    }

    console.log('.devicedesktop'+device_id+':eq(0)' + ' agregar el device_id ' + device_id + ' en el grupoid ' + group_id)
   $('.gnamescajas:eq('+lastgroup+')').before('<div class="gnamescajas grupo'+group_id+'"><div class="container-group-title"><span class="gnamestyle">'+name+'</span><div class="dropdown" style="float: right;"><span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="glyphicon glyphicon-option-horizontal  engra" aria-hidden="true"></span></span><span class="glyphicon glyphicon-menu-hamburger toogleg'+group_id+'" groupid="'+group_id+'" aria-hidden="true"></span><ul class=" dropdown-menu dropdown-menu3" aria-labelledby="dropdownMenu1"><li><span style="color: black; margin-left: 12px;" class="deletegroup" type="2" name="'+name+'" groupid="'+group_id+'" user_id="'+user_id+'">Eliminar grupo</span></li></ul></div></div></div><div class="container-devices-group'+group_id+'"></div>')

   $('.container-devices-group'+group_id).append(dev);

   $('.toogleg'+group_id).click(function(){
        id = $(this).attr('groupid')
        console.log(id)
        $( ".container-devices-group"+id ).slideToggle( "slow" );
    })


}
    $('.closecoment').click(function(){
        $('.optext').hide();
        $('.device').css('height','50px');
        $('.optext').css('opacity',0);
    })
$('.opentext').click(function () {
    $('.optext').css('opacity',0);
    ide = $(this).attr('ide');
    console.log(ide)
    $('.optext').hide();
    $('.device').css('height','50px');


    $('.device_'+ide).css('height','155px');
    $('.opentext'+ide).show();
    $('.optext').css('opacity',100);
})
    show_geofences = function(radius,lat_,lng_,id,type,poly_data,color,name){
    console.log('jewel')
    if(type=='circle'){
        l = parseFloat(lat_)
        ln = parseFloat(lng_)

        draw_circle = new google.maps.Circle({
            center: {lat: l, lng: ln},
            radius: radius,
            strokeColor: "#cccccc",
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: color,
            fillOpacity: 0.45,
            zIndex: 1,
            map: map
        })
        var myLatlng= new google.maps.LatLng(lat_,lng_ );
        var label= new MarkerWithLabel({
            position: myLatlng,
            map: map,
            icon: " ",
            labelContent: "<div>"+name+"</div>",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            zIndex: -1
        });


        draw_circle.set('id',id)
        geofences_container.push(draw_circle);
        geofences_labels.push(label);
    }else{
        var poly_data = JSON.parse(poly_data);

        var myLatlng= new google.maps.LatLng(poly_data[0].lat,poly_data[0].lng );
        var label= new MarkerWithLabel({
            position: myLatlng,
            map: map,
            icon: " ",
            labelContent: "<div>"+name+"</div>",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            zIndex: -1
        });
        var draw_circle = new google.maps.Polygon({
            paths: poly_data,
            fillColor: color,
            strokeWeight: 0,
            fillOpacity: 0.35,
            map: map,
            zIndex: -1
          });
          draw_circle.set('id',id)
          geofences_container.push(draw_circle);
          geofences_labels.push(label);
    }

}

function showstates(){
    ide = 10
    $.ajax({
            url:'/get/states',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: ide },
            success: function(states){

               console.log(states)
               $.each(states,function(a,b){

                console.log(b)
                console.log(b.id)
                console.log(b.poly_data)
                console.log(b.name)
                show_geofences(0,0,0,b.id,'poly',b.polydata,b.color,b.name)
               })

            },
            error: function(data){
                console.log(data)
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
}
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

    $('.enganchemodal').click(function(){
        ideeng = $(this).attr('ide');
        engdevname = $(this).attr('name');
        console.log('ir por enganche ' + ideeng)
        
        function gotoEng(lat,lng){

            $('.gotoen').click(function(){
                engmap.setZoom(15);
                engmap.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                })


             
        }
        


        $.ajax({
            url:'/device/getEnganche',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: ideeng },
            success: function(enganche){
                 
                var mapOptions = {
                    zoom: 4,
                    center:  new google.maps.LatLng(23.483505, -102.058313),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                console.log('crear mapa ' + 'engMap'+ideeng)
                engmap = new google.maps.Map(document.getElementById('engMap'+ideeng), mapOptions);
                enghtml = '<table class="table table-striped">'
                $.each(enganche['enganche'],function(a,eng){
                     
                    
                    enghtml = enghtml + '<tr><td>'+engdevname+'</td><td>'
                    if(eng.eventCode==21){
                        enghtml   = enghtml +'Enganchada</td><td>' +eng.updateTime
                    }
                    if(eng.eventCode==20){
                        enghtml = enghtml + 'Desenganchada</td><td>' +eng.updateTime

                    }
                    enghtml = enghtml + '</td>'
                    enghtml = enghtml + '<td><button class="gotoen" lat="'+eng.lat+'" lng="'+eng.lng+'" onclick="gotoEng()">Ir</button></td></tr>'
                    var myLatlng = new google.maps.LatLng(eng.lat, eng.lng);
                    
                    
                    var marker = new google.maps.Marker({
                    position: myLatlng,
                    zIndex:9999999,
                    icon:{
                        url:'http://usamexgps.com/images/truck3.png'
                    },

                    map:engmap
                });
                   
                })
                
                enghtml = enghtml + '</table>'
                
                
                $('#enghtml'+ideeng).html(enghtml)
                gotoEng()


            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
    })
    $('.panicmodal').click(function(){
        ide = $(this).attr('ide');
        console.log(ide)
        $.ajax({
            url:'/device/getPanic',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: ide },
            success: function(panic){
                console.log(panic)
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
                console.log(panic['panic'][0].rssi + ' po ')
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
        $(".devices-left .device").each(function(index) {
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

    $("#search_mobile").on("keyup", function() {

        var value = $(this).val();

        var value = value.toLowerCase();
        console.log(value)
        $(".devices_mobile .mobile-device").each(function(index) {
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
        console.log('va')
        var value = $(this).val();

        var value = value.toLowerCase();

        $(".s-left .device").each(function(index) {
            name = $(this).attr('name');
            console.log(name + ' ' + value)
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
    iblabels = []
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
    truck_image = 'truck_green_.png'
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
            url:'http://digitaladmintrack.com/images/truck_green_.png'
        },

        rotation:50,
        id:{{ $device->id }},
        type_id:{{ $device->type_id }},
        name: "{{$device->name}}"
    });
    @else
    var marker{{ $device->id }} = new google.maps.Marker({
        position: myLatlng{{ $device->id }},
        zIndex:888888,
        icon:{
            url:'http://digitaladmintrack.com/images/red_truck_.png'
        },

        rotation:50,
        id:{{ $device->id }},
        type_id:{{ $device->type_id }},
        name: "{{$device->name}}"
    });
    @endif




    boxText{{ $device->id }} = document.createElement("div");
    boxText{{ $device->id }}.style.cssText = "background-color: white; color:grey; padding: 10px; border-radius:5px";


                        //MOTOR PARA DESCRIPCION
                        @if($device->engine == 1)
                        <?php $motor = '<span  >Motor Encendido</span>'; ?>
                        @endif
                        @if($device->engine == 0)
                        <?php $motor = '<span  >Motor Apagado</span>'; ?>
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

                         coment = ''
                        @if(isset($device->pop->comentario))
                        coment = " {{ $device->pop->comentario }} "
                        byuser = " {{ $device->pop->user_name }}"
                        updatetimecoment = " {{ $device->pop->created_at }}"
                        idpop = "{{ $device->pop->id }}"
                        @else
                        coment = '-'
                        byuser = '-'
                        updatetimecoment = '-'
                        idpop = " "
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


   boxText{{ $device->id }}.innerHTML ='<div class="pop idepop{{ $device->id }}" idepop="'+idpop+'"><span class="titlepop">Unidad: {{$device->name}}</span><hr class="hrpop"><span class="textpop">{{ $device->lastpacket->updateTime }} | {!! $motor !!}</span><br><span class="textpop">'+ stopped_time +' Detenido</span><br><span class="direccion_{{ $device->id }}"></span><div class="comentpop"><table class="tablepop"><tr class="titletablepop"><td><span id="bubleuser{{ $device->id }}">'+byuser+'</span></td><td style="text-align: right;"><span id="bubledate{{ $device->id }}">'+updatetimecoment+'</span></td></tr><tr><td colspan="2"><span id="bublecoment{{ $device->id }}">'+coment+'</span></td></tr></table></div></div>'




                        @else


                        boxText{{ $device->id }}.innerHTML ='<div class="pop idepop{{ $device->id }}" idepop="'+idpop+'"><span class="titlepop">Unidad: {{$device->name}}</span><hr class="hrpop"><span class="textpop">{{ $device->lastpacket->updateTime }} | {!! $motor !!}</span><br><span class="direccion_{{ $device->id }}"></span><br><div class="comentpop"><table class="tablepop"><tr class="titletablepop"><td><span id="bubleuser{{ $device->id }}">'+byuser+'</span></td><td style="text-align: right;"><span id="bubledate{{ $device->id }}">'+updatetimecoment+'</span></td></tr><tr><td colspan="2"><span id="bublecoment{{ $device->id }}">'+coment+'</span></td></tr></table></div></div>';

                        @endif

                        var myOptions = {
                           content: boxText{{ $device->id }}
                           ,disableAutoPan: false
                           ,maxWidth: 0
                           ,pixelOffset: new google.maps.Size(-140, 0)
                           ,zIndex: null
                           ,boxStyle: {
                              background: "white"
                              ,width: "320px"
                              ,borderRadius:"6px"
                              ,border: "1px solid #d2d2d2"
                              ,color:'grey'
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
                            console.log('abrir')
                            var latlng = {lat: {{ $device->lastpacket->lat }}, lng: {{$device->lastpacket->lng}} };

                geocoder.geocode({'location': latlng}, function(results, status) {

                   if (status === 'OK') {
                    if (results[1]) {

                      $('.direccion_{{$device->id}}').html(results[1].formatted_address)


                  } else {
                      window.alert('No results found');
                  }
              } else {
                window.alert('Geocoder failed due to: ' + status);
            }

        })


                            ib{{ $device->id }}.open(map, this);
                        });

                        shortName = '{{ $device->name }}'
                        if(shortName.length >= 5){
                            shortName = shortName.substring(0, 6);
                        }
                        @if($device->engine == 1)
                            @if($device->type_id == 2)
                            var labelText = shortName+' &nbsp; {!! $heading !!}'

                            @else
                            var labelText = shortName+' &nbsp; {!! $heading !!}'
                            @endif
                        @endif


                        @if($device->engine == 0)
                        @if($device->type_id == 2)
                        var labelText = shortName+' &nbsp; {!! $heading !!}'
                        @else
                        var labelText = shortName+' &nbsp; {!! $heading !!}'
                        @endif
                        @endif


                        var myOptionsLabel = {
                           content: labelText
                           ,boxStyle: {
                            background: "#212529",
                            borderRadius:"5px",
                            color: 'white',
                            zIndex: 999999,
                            opacity:0.95,
                            padding:'5px',
                            height:'28px',
                            position:'absolute',
                            fontSize: "8pt",
                            width: "70px"
                        }
                        ,disableAutoPan: true
                        ,pixelOffset: new google.maps.Size(15, -28)
                        ,position: myLatlng{{ $device->id }}
                        ,closeBoxURL: ""
                        ,device_id: {{ $device->id }}
                        ,isHidden: false
                        ,pane: "mapPane"
                        ,enableEventPropagation: true
                    };

                    var ibLabel{{ $device->id }} = new InfoBox(myOptionsLabel);
                    ibLabel{{ $device->id }}.open(map, marker{{ $device->id }});
                    ibLabel{{ $device->id }}.device_id = {{ $device->id }};
                    ibLabel{{ $device->id }}.type_id = {{ $device->type_id }};
                        //*LABEL*//
                        var label{{ $device->id }} = new MarkerWithLabel({
                            position: myLatlng{{ $device->id }},

                            icon: " ",
                            labelContent: "<div   onclick='showinfo({{$device->id}})'><span class='glyphicon @if($device->dstate_id==1) movement  @endif  glyphicon-circle-arrow-up fa-rotate-{{$device->lastpacket->heading}}' aria-hidden='true'></span> {{$device->name}} @if($device->boxs_id != null) -> {{ $device->boxs->name }} @endif</div><div class='none windowinfo window{{$device->id}}'>Velocidad:**** <span >{{$device->lastpacket->speed }}</span></div>",
                            labelAnchor: new google.maps.Point(22, 0),
                            labelClass: "labels", // the CSS class for the label
                            labelStyle: {opacity: 0.75},
                            id:{{ $device->id }},
                            type:{{ $device->type_id}},
                            name: "{{$device->name}}"
                        });
                        mwl.push(label{{ $device->id }})
                        m.push(marker{{ $device->id }})
                        iblabels.push(ibLabel{{ $device->id }})


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
              $('#el').animate({scrollTop:0}, 500, 'swing', function() {

});
              console.log(myLatilng)
              console.log("cuantos " + c.getSize());
              console.log("marcadores: " + c.getMarkers());
              names = '<button type="button" class="close closealo" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
              $.each(c.getMarkers(),function(index,value){


                names =  names + 'Equipo: <span style="color:grey">'+ value.name + ' </span><br> ';

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


var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markersSearch = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markersSearch.forEach(function(marker) {
            marker.setMap(null);
          });
          markersSearch = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markersSearch.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });


        $('.showCajas').click(function(){
            if($(this).is(':checked')==true){
                console.log('mostrar')
                $.each(m, function( index, value ) {

                    if(value.type_id == 2){
                        markerCluster.addMarker(m[index]);
                    }
                })
                $.eac

                $.each(m, function( index, value ) {

                    if(value.type_id == 2){
                        m[index].setVisible(true)
                    }
                })


                 $.each(mwl, function( index, value ) {

                    if(value.type_id == 2){
                        mwl[index].setVisible(true)
                    }
                })

                  $.each(iblabels, function( index, value ) {

                    if(value.type_id == 2){
                        value.show();
                    }
                })
            }else{
                console.log('esconder')

                $.each(m, function( index, value ) {

                    if(value.type_id == 2){
                        markerCluster.removeMarker(m[index]);
                    }
                })
                $.eac


                 $.each(iblabels, function( index, value ) {

                    if(value.type_id == 2){
                        value.hide();
                    }
                })

                $.each(m, function( index, value ) {

                    if(value.type_id == 2){
                        m[index].setVisible(false)
                    }
                })

                $.each(mwl, function( index, value ) {

                    if(value.type_id == 2){
                        mwl[index].setVisible(false)
                    }
                })
            }
        })


        $('.showDevices').click(function(){
            if($(this).is(':checked')==true){
                console.log('mostrar')
                $.each(m, function( index, value ) {

                    if(value.type_id == 1){
                        markerCluster.addMarker(m[index]);
                    }
                })
                $.each(m, function( index, value ) {

                    if(value.type_id == 1){
                        m[index].setVisible(true)
                    }
                })


                 $.each(mwl, function( index, value ) {

                    if(value.type_id == 1){
                        mwl[index].setVisible(true)
                    }
                })

                  $.each(iblabels, function( index, value ) {

                    if(value.type_id == 1){
                        value.show();
                    }
                })
            }else{
                console.log('esconder')

                $.each(m, function( index, value ) {

                    if(value.type_id == 1){
                        markerCluster.removeMarker(m[index]);
                    }
                })


                 $.each(iblabels, function( index, value ) {

                    if(value.type_id == 1){
                        value.hide();
                    }
                })

                $.each(m, function( index, value ) {

                    if(value.type_id == 1){
                        m[index].setVisible(false)
                    }
                })

                $.each(mwl, function( index, value ) {

                    if(value.type_id == 1){
                        mwl[index].setVisible(false)
                    }
                })
            }
        })

            $('.showDevice').click(function(){

                id=$(this).attr('ide');
                if($(this).is(':checked')==true){

                 $.each(m, function( index, value ) {

                    if(value.id == id){
                        m[index].setVisible(true)
                    }
                })


                 $.each(mwl, function( index, value ) {

                    if(value.id == id){
                        mwl[index].setVisible(true)
                    }
                })

                  $.each(iblabels, function( index, value ) {

                    if(value.device_id == id){
                        value.show();
                    }
                })

             }else{

                $.each(iblabels, function( index, value ) {

                    if(value.device_id == id){
                        value.hide();
                    }
                })

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

                 $([document.documentElement, document.body]).animate({
        scrollTop: $("#map").offset().top
    }, 0000);
            })

            $('.gotoMobile').click(function(){
                map.setZoom(15);
                map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));

                 $([document.documentElement, document.body]).animate({
        scrollTop: $("#map").offset().top
    }, 0000);



            })


            function wait(ms){
                var start = new Date().getTime();
                var end = start;
                while(end < start + ms) {
                    end = new Date().getTime();
                }
            }
            function go(id,lat,lng,geofence,dstate_id,speed,device_name,heading,movement,status,EventCode,updateTime,stop_time,stop,odometro,previous_heading,odometro_total,type_id,comentario,engine,comentario_id,comentario_update_time,comentario_user_id,comentario_user_name){


                            // REMOVER DEL OFF
                            $('#off_'+id).remove()
                            //
                            //HEADING
                            $('.move'+id).removeClass('fa-rotate-'+previous_heading)
                            $('.move'+id).addClass('fa-rotate-'+heading)
                            $('.move'+id).addClass('ahora'+heading)
                            //HEADING
                            $('.odometro'+id).html(odometro)
                            if(stop==1){
                                //poner rojo
                                $('.move'+id).removeClass('white')
                                 $('.move'+id).addClass('shutdown')
                                $('.moveiconl'+id).removeClass('iconblue')

                                $('.move'+id).attr('data-original-title','Unidad detenida n')





                                if(type_id ==  1){
                                    $('.moveIcon'+id).attr('src','http://usamexgps.com/images/red_truck_.png')
                                }
                                if(type_id ==  2){
                                    $('.moveIcon'+id).attr('src','http://usamexgps.com/images/red_box_.png')
                                }

                                icon_move =  '<span class="icon-arrow-circle-up  leicon shutdown  fa-rotate-'+heading+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidad en Movimiento"></span>'
                            }
                            if(stop==0){
                                //poner verde
                                $('.move'+id).removeClass('shutdown')
                                $('.move'+id).addClass('white')
                                $('.moveiconl'+id).addClass('iconblue')
                                $('.move'+id).addClass('sepusoverde')
                                $('.move'+id).attr('data-original-title','Unidad en Movimiento')
                                if(type_id == 1){
                                    $('.moveIcon'+id).attr('src','http://usamexgps.com/images/truck_green_.png')
                                }
                                if(type_id == 2){
                                    $('.moveIcon'+id).attr('src','http://usamexgps.com/images/box_green_.png')
                                }

                                icon_move =  '<span class="icon-arrow-circle-up  leicon green  fa-rotate-'+heading+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidad en Movimiento"></span>'
                            }


                            $(".uptime"+id).timer('remove');
                            $(".uptime"+id).css('color','#6d6d6d');
                            $(".timer"+id).timer('remove');
                            $(".timer"+id).timer();
                            if(movement == true){
                                movement_class = 'movement'
                            }else{
                                movement_class='stop'
                            }

                            $( ".device_"+id+ " a" ).attr('lat',lat)
                            $( ".device_"+id+ " a" ).attr('lng',lng)

                            //$.notify("nuevo paquete", "info");
                            akaname = 'marker'+id
                            buble = 'ib'+id

                            lalabel = 'ibLabel'+id

                            motor = '<span  ></span>';
                      if(engine == 1){
                        motor = '<span  >Motor Encendido</span>';
                      }


                        if(engine == 0){
                            motor = '<span  >Motor Apagado</span>';
                        }


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




                               a =  '<div class="pop idepop'+id+'" idepop="'+idpop+'"> <span class="titlepop">Unidad: '+device_name+'</span><hr class="hrpop"><span class="textpop">'+updateTime+' | '+motor+'</span><br><span class="textpop">'+ stopped_time +' Detenido</span><br><span class="direccion_'+id+'"></span><div class="comentpop"><table class="tablepop"><tr class="titletablepop"><td><span id="bubleuser'+id+'">'+comentario_user_name+'</span></td><td style="text-align: right;"><span id="bubledate'+id+'">'+comentario_update_time+' </span></td></tr><tr><td colspan="2"><span id="bublecoment'+id+'">'+comentario+'</span></td></tr></table></div></div>'
                                this[buble].setContent(a)
                            }else{

                                a =  '<div class="pop idepop'+id+'" idepop="'+idpop+'"><span class="titlepop">Unidad: '+device_name+'</span><hr class="hrpop"><span class="textpop">'+updateTime+' | '+motor+'</span><br><span class="direccion_'+id+'"></span><div class="comentpop"><table class="tablepop"><tr class="titletablepop"><td><span id="bubleuser'+id+'">'+comentario_user_name+'</span></td><td style="text-align: right;"><span id="bubledate'+id+'">'+comentario_update_time+' </span></td></tr><tr><td colspan="2"><span id="bublecoment'+id+'">'+comentario+'</span></td></tr></table></div></div>'


                             this[buble].setContent(a)
                         }

                         short_device_name = device_name
                         if(short_device_name.length > 5){
                            short_device_name = short_device_name.substring(0, 6);
                        }
                        if(stop == 0){
                            if(type_id == 1){
                                leimage = 'http://usamexgps.com/images/truck_green_.png'
                                lalabelcontent =  short_device_name + ' ' + icon_move;
                            }else{
                                leimage = 'http://usamexgps.com/images/box_green_.png'
                                lalabelcontent = short_device_name + ' ' + icon_move;
                            }


                        }
                        if(stop == 1){
                            if(type_id == 1){
                                leimage = 'http://usamexgps.com/images/red_truck_.png'
                                lalabelcontent =  short_device_name + ' ' + icon_move;
                            }else{
                                leimage = 'http://usamexgps.com/images/red_box_.png'
                                lalabelcontent =  short_device_name + ' ' + icon_move;
                            }


                        }


                        if(EventCode == 20){
                            $('.engine'+id).removeClass('green')
                            $('.engine'+id).addClass('shutdown')
                            $('.engineicon'+id).removeClass('icongreen')
                            $('.engine'+id).attr('data-original-title','Unidad Apagada')
                            elengine = '<span class="engine'+id+' glyphicon glyphicon-record shutdown" data-toggle="tooltip" data-placement="top" title="Unidad Apagada *"></span>'
                            lalabelcontent = short_device_name + ' ' + icon_move

                        }



                        if(EventCode == 21){
                            // poner azul
                            $('.engine'+id).removeClass('shutdown')
                            $('.engine'+id).addClass('white')
                            $('.engineicon'+id).addClass('icongreen')
                            $('.engine'+id).attr('data-original-title','Unidad Encendida')
                            elengine = '*<span class="engine'+id+' glyphicon glyphicon-record green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida *"></span>'
                            lalabelcontent =  short_device_name  + ' ' + icon_move

                        }
                        this[lalabel].setContent(lalabelcontent)

                            //
                            labelname = 'label'+id
                            myLatlng = new google.maps.LatLng(lat, lng);
                            this[labelname].setPosition( myLatlng );
                            this[labelname].labelContent = "---<div   onclick='showinfo("+id+")'><span class='glyphicon glyphicon-circle-arrow-up "+ movement_class +" fa-rotate-"+heading+"' aria-hidden='true'></span>"+device_name+" namedevice</div><div class='none windowinfo window"+id+"'>Fecha: "+updateTime+" <br>Velocidad: "+speed+"<br> <span class='direccion_"+id+"'></span></div>";
                            this[labelname].label.setContent();

                            this[akaname].setDuration(1000)
                            this[akaname].setEasing('linear');
                            this[akaname].setPosition(myLatlng);
                            if(stop == 0){
                                this[akaname].setIcon('http://digitaladmintrack.com/images/truck_green_.png');
                            }else{
                                this[akaname].setIcon('http://digitaladmintrack.com/images/red_truck_.png');
                            }

                            var o  = odometro_total / 1000;
                            b = parseFloat(o).toFixed(1);
                            $('.speed'+id).attr('data-original-title',speed + ' km/h. | ' + b + ' kms')
                            $('.speed_'+id).html(speed + ' km/h.')
                            if(speed < 100){
                                //poner shut
                                $('.speed'+id).removeClass('white')
                                $('.speed'+id).addClass('shutdown')
                                $('.speedicon'+id).removeClass('iconred')

                            }
                            if(speed >= 100){
                                // poner rojo
                                $('.speed'+id).removeClass('shutdown')
                                $('.speed'+id).addClass('white')
                                $('.speedicon'+id).addClass('iconred')

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


                         // revisar equipos sin reportes
                         function check_for_delays(){
                            setInterval(function(){
                                console.log('revisando')

                            },30000);
                        }
                        check_for_delays()

                        function dothis(){
                            console.log('enviar deñay')
                            $.ajax({
                                url:'/device/checkDelay',
                                type:'POST',
                                dataType: 'json',
                                headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                               data: { id: 5 },
                               success: function(delay_device){

                                 $.each(delay_device,function(index,value){


                                    $.each(value,function(index,val){

                                        var objname = "ibLabel"+val.id;

                                        lalabel = 'ibLabel'+val.id

                                        if (typeof window[lalabel] != "undefined") {
                                           window[lalabel].setContent( val.name)

                                           if(val.type_id == 1){
                                            $('.dev_off').removeClass('nones')
                                            set=1
                                            $.each($('.off_devices li'),function(v,x){
                                                if('off_'+val.id == x.id){
                                                    set = 0
                                                }else{
                                                }
                                            })

                                            if(set == 1){
                                                lat = $('.device_'+val.id+' div div a').attr('lat')
                                                lng = $('.device_'+val.id+' div div a').attr('lng')
                                                $('.off_devices').append('<li id="off_'+val.id+'"><a class="goto" lat="'+lat+'" lng="'+lng+'">'+val.name+'</a></li>')
                                                $('.goto').click(function(){
                                                    map.setZoom(15);
                                                    map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                                                })

                                            }



                                        }

                                    }else{
                                    }

                                })
                                            //console.log('x')
                                            //console.log(value['id'])
                                            var objname = "ibLabel261";
                                            //console.log(window[objname])

                                        })
                             },
                             error: function(data){
                                console.log(data)
                                var errors = data.responseJSON;
                                console.log(errors);
                            }
                        })

                            // REVISAR SI YA NO HAY DEVICES
                            son = $('.off_devices li').length

                            if(son == 0){
                                $('.dev_off').addClass('nones')
                            }

                        }
                        dothis();
                        var i = setInterval(dothis, 30000);

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

                        var socketApp = io(':3011');
                        console.log(socket)

socketApp.on('responsemensaje', function (row) {
	console.log('resonse mensaje')
	data = JSON.parse(row);
	console.log(data)
	$('.contmensajes'+data.id).append('<div class="notification not  "><span class=" not"><div class="not" style="float:left">  <img src="'+data.profile+'" alt="..." class="img-circle"> </div><div class="not" style="float:left;     padding: 0px 5px; width: 206px;"><b>'+data.name+'</b> <span class="grey">'+data.updatetime+'</span> <br><span class="black">'+data.mensaje+'</span></div><div class="not" style="clear:both"></div></span></div>');
/// $('.contmensajes').animate({scrollTop: 200});

$('.contmensajes').animate({ scrollTop: $('.contmensajes')[0].scrollHeight}, "slow")



})
socketApp.on('res', function (row) {
  console.log(row)
data = JSON.parse(row);
  console.log(data.id)
 // $('.contmensajes'+data.id).append('<div class="notification not  "><span class=" not"><div class="not" style="float:left">  <img src="/profile/thumb_1_22128.png" alt="..." class="img-circle"> </div><div class="not" style="float:left;     padding: 0px 5px; width: 206px;"><b>Horacio Cron 6</b> <span class="grey"> 1 day after </span> <br><span class="black">'+data.mensaje+'</span></div><div class="not" style="clear:both"></div></span></div>');
 // $('.contmensajes').animate({scrollTop: 200});




  author_id = data.user_id;
  console.log(author_id)
  $.ajax({
        url:'notifications/getlastbyauthorMessages',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { author_id:author_id },
        success: function(r){
            $('.live').append(r['notification'])
            $('.badge-notify-p-count').removeClass('none');
            $('.badge-notify-p-count').show()
            $('.badge-notify-p-count').html(r['newnotifications']);
            $('.comment-icon').addClass('blue')



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
                                    $.notify(r['message'], {
                                      style: 'happyblues',
                                      className: 'superblues',
                                      clickToHide: false,
                                      autoHideDelay: 5000,
                                      position: 'bottom right'
                                  });



            $(".notification .nlink").on("click",function(e){

                ide = $(this).attr('ide');
                device_id = $(this).attr('device_id');
                link = $(this).attr('to');
                nid = $(this).attr('nid')
                user_id = $(this).attr('user_id')
                console.log(user_id + ' ' + nid)


                $.ajax({
                    url:'/message/notification_read',
                    type:'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { id:ide , device_id:device_id, user_id:user_id},
                    success: function(r){
                      console.log('que paso')
                      console.log(nid)

                      $('.notification'+nid).addClass('readed')
                      $('#mensajes').html(r)
                     // $('.contmensajes').animate({scrollTop: 200});
                      $('.contmensajes').animate({ scrollTop: $('.contmensajes')[0].scrollHeight}, "slow")
                      bcoment()
                      closeconv()
                      $('.notifications').addClass('none')
                      $('.pyramid').addClass('none')
                        console.log('go')
                    },
                    error: function(data){
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
                return false

             });
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
    console.log('expresion')

var audio = new Audio('http://usamexgps.com/sounds/for-sure.mp3');

audio.play();


})


                        socket.on("message<?php echo Auth::user()->client_id  ?>", function(data){


                            go(data['device_id'],data['lat'], data['lng'],data['geofence'],data['dstate_id'],data['Speed'],data['device_name'],data['Heading'],data['movement'],data['status'],data['EventCode'],data['updateTime'],data['stop_time'],data['stop'],data['odometro'],data['previous_heading'],data['odometro_total'],data['type_id'],data['comentario'],data['engine'],data['comentario_id'],data['comentario_update_time'],data['comentario_user_id'],data['comentario_user_name'])
                        })

                        socket.on("jammer<?php echo Auth::user()->client_id  ?>", function(data){
                            console.log('jammer')
                            console.log(data)
                            $('.jammer').show();
                            $('.jammer').html('El equipo de la unidad '+ data['response'][1] + ' ha detectado un intento de robo <button id="pause" class="btn btn-danger stopJammer" ide="'+data['response'][2]+'">Terminar Alerta</button>')

                            var audioElement = document.createElement('audio');
                            audioElement.setAttribute('src', 'http://www.soundjay.com/misc/sounds/bell-ringing-01.mp3');

                            audioElement.addEventListener('ended', function() {
                                this.play();
                            }, false);

                            audioElement.play();
        $("#status").text("Status: Playing");

        $('#pause').click(function() {
        audioElement.pause();
        $("#status").text("Status: Paused");
    });


                            $('.stopJammer').click(function(){
                                ide = $('.stopJammer').attr('ide');
                                console.log('parar al ' + ide)
                                    $('.jammer').hide()
                                 $.ajax({
                                url:'/stop/jammer',
                                type:'POST',
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: { id: ide },
                                success: function(r){
                                    console.log(r)
                                }
                            })

                            })
                        })
$('.stopJammer').click(function(){
    $('.jammer').hide()
                                ide = $(this).attr('ide');
                                 $.ajax({
                                url:'/stop/jammer',
                                type:'POST',
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: { id: ide },
                                success: function(r){
                                    console.log(r)
                                }
                            })

                                console.log('parar al ' + ide)

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
function bcoment(){
  $('.button_coment').click(function(){
  idebc = $(this).attr('ide')
  user_id = $(this).attr('user_id')
  message = $('.coment'+idebc).val();
  device_name = $(this).attr('device_name')
  profile = $(this).attr('profile')
  name_ = $(this).attr('name')
  if(message == ''){
    return false;
  }
    console.log(message + ' al ' + idebc)
  $.ajax({
            url:'/insert/coment',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: idebc,message:message,user_id:user_id },
            success: function(pop){
                console.log(pop)
                $('.textbox').val('')
                name = pop[0].user.name
                $('.myModalmensaje'+idebc).modal('hide')
                updatetime = pop[0].updateTime
                console.log(idebc)
                socketApp.emit('mensaje', '{ "id" : "'+idebc+'","user_id":'+user_id+', "mensaje":"'+message+'", "device_name":"'+device_name+'" , "profile":"'+profile+'" , "name":"'+name_+'" , "updatetime":"'+updatetime+'"}');
                socketApp.emit('mensajeall', '{ "id" : "'+idebc+'","user_id":'+user_id+', "mensaje":"'+message+'", "device_name":"'+device_name+'" , "profile":"'+profile+'" , "name":"'+name_+'" , "updatetime":"'+updatetime+'"}');

                console.log('mensaje emitido')
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
                                          "background-color": "#0fbf67"
                                      }
                                  }
                              });
                                    $.notify('Se ha ingresado un nuevo comentario con exito', {
                                      style: 'happyblues',
                                      className: 'superblues',
                                      clickToHide: false,
                                      autoHideDelay: 8000,
                                      position: 'bottom left'
                                  });
                                    $('.optext').hide();

    $('.optext').css('opacity',0);



    updateText(idebc,message,name,updatetime)



            },
            error: function(data){
                console.log(data)
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
})
}
$('.button_coment').click(function(){
    ide = $(this).attr('ide')
    user_id = $(this).attr('user_id')
    message = $('.coment'+ide).val();
    device_name = $(this).attr('device_name')
    console.log(message + ' al ' + ide)
    $.ajax({
            url:'/insert/coment',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { id: ide,message:message,user_id:user_id },
            success: function(pop){
                console.log(pop)
                name = pop[0].user.name
                $('.myModalmensaje'+ide).modal('hide')
                updatetime = pop[0].updateTime
                console.log(ide)
                socketApp.emit('mensaje', '{ "id" : "'+ide+'","user_id":'+user_id+', "mensaje":"'+message+'", "device_name":"'+device_name+'"}');
                console.log('mensaje emitido')
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
                                          "background-color": "#0fbf67"
                                      }
                                  }
                              });
                                    $.notify('Se ha ingresado un nuevo comentario con exito', {
                                      style: 'happyblues',
                                      className: 'superblues',
                                      clickToHide: false,
                                      autoHideDelay: 8000,
                                      position: 'bottom left'
                                  });
                                    $('.optext').hide();

        $('.optext').css('opacity',0);



        updateText(ide,message,name,updatetime)



            },
            error: function(data){
                console.log(data)
                var errors = data.responseJSON;
                console.log(errors);
            }
        })
})
function updateText(id,message,name,updatetime){
    console.log('#bublecoment'+id + ' ->'+message )
$('#bublecoment'+id).html(message)
$('#bubleuser'+id).html(name)
$('#bubledate'+id).html(updatetime)
}


                    </script>
                    <!-- Scripts -->
                    <script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
                    @endsection
