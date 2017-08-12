@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-3 devices-left">
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
        <div class="device <?php echo $color_class ?> animate device_{{ $device->id }}" name="{{ $device->name }}">
            <div class="">
                <a class="black goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
                    lng = "{{ $device->lastpacket->lng }}" style="float:left">
                    <input type="checkbox" class="showDevice" ide="{{ $device->id }}" checked>
                    <span data-toggle="tooltip" data-placement="top" title="@if($device->boxs_id != null) -> {{ $device->boxs->name }} @endif">{{ ucfirst($device->name) }}  </span>
                                 
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
                                
                                <span class="icon-speedometer leicon " data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }}"></span> <span class="speed{{ $device->id }}"> {{ $device->lastpacket->speed }} </span>
                                
                                {!! $device->battery_alarm($config->battery_alarm,$device->lastpacket->power_bat) !!}
                                {!! $device->rssi_alarm($config->rssi_alarm,$device->lastpacket->rssi) !!}  </a>

                    <p class="text11 mb0" style="float:right">
                            <a href="/travel/{{ $device->travel->tcode->id }}">{{ str_limit(ucfirst($device->travel->route->destination->name), $limit = 15, $end = '...') }} </a>
                             
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
                            <span id="state_{{ $device->id }}"><?php echo $state ?> </span>
                           <!-- <span class="badge device_timer_{{ $device->id }}"></span>-->
                        </p>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>

                </div>
                

                    @endif
                    @endforeach
                    @if($onroad_devices==0   )
                    <p style="padding: 10px; text-align: center; color: grey;">No tienes equipos en ruta</p>
                    @endif
                </div>

                <div   id="map"></div>
                <div class="col-md-3 devices-right">
                    <input type="text" id="search_right" style="width:100%" placeholder="  Buscar Unidad"></input>
                <span class="rightTop"></span>
                    @foreach($devices  as $device)
                    @if($device->status==0)
                    <?php $devices_availables++ ?>

                    
                            @if(isset($device->lastpacket->lat ))
                            <div class="device device-off device_{{ $device->id }}  @if($device->dstate_id==1) flash animated msv @endif" name="{{ $device->name }}">
                        <div class="">
                            <input type="checkbox" class="showDevice" ide="{{ $device->id }}" checked><a class="black goto text11 mb0" lat="{{ $device->lastpacket->lat }}"
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
                                
                                <span class="icon-speedometer leicon " data-toggle="tooltip" data-placement="top" title="{{ $device->lastpacket->speed }}"></span> <span class="speed{{ $device->id }}"> {{ $device->lastpacket->speed }} </span>
                                
                                {!! $device->battery_alarm($config->battery_alarm,$device->lastpacket->power_bat) !!}
                                {!! $device->rssi_alarm($config->rssi_alarm,$device->lastpacket->rssi) !!}  </a>

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
                    @endsection
                    @section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/master.js"></script>
<script>
$("#search_right").on("keyup", function() {
var value = $(this).val();
 
var value = value.toLowerCase();

$(".devices-right .device").each(function(index) {
    name = $(this).attr('name'); console.log(name)

    if (name.indexOf(value) !== 0) {
            $(this).hide()
        }
        else {
            $(this).show()
        }

})

 
});



$("#search_left").on("keyup", function() {
var value = $(this).val();
 
var value = value.toLowerCase();

$(".devices-left .device").each(function(index) {
    name = $(this).attr('name'); console.log(name)

    if (name.indexOf(value) !== 0) {
            $(this).hide()
        }
        else {
            $(this).show()
        }

})

 
});



$(".devices-right .devices").each(function(index) {
    console.log(index)
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
                    marker = new google.maps.Marker({
                        //marker = new SlidingMarker({
                        map: map,
                        title: 'I\m sliding marker'
                    });

            m = []
            mwl = []
            van =1
             @foreach($devices  as $device)

             @if(isset($device->lastpacket->lat ))
             van++
             sec = {{ $device->status($device->lastpacket) }} * 60;

               $(".timer"+{{$device->id}}).timer({ seconds: sec, });

                     var myLatlng{{ $device->id }}= new google.maps.LatLng({{ $device->lastpacket->lat   }},{{ $device->lastpacket->lng   }} );
                      
                      var marker{{ $device->id }} = new google.maps.Marker({
                        position: myLatlng{{ $device->id }},
                        zIndex:9999999,
                        icon:{
                            url:'http://usamexgps.com/images/truck3.png',
                            labelOrigin: new google.maps.Point(15, 45)
                        },

                        rotation:50,
                        id:{{ $device->id }}
                    });

              boxText{{ $device->id }} = document.createElement("div");
                    boxText{{ $device->id }}.style.cssText = "border: 1px solid grey;  padding: 5px;";


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
                                <?php $heading = '<span class="icon-arrow-circle-up move'. $device->id .' fa-rotate-'. $device->lastpacket->heading .' leicon red" data-toggle="tooltip" data-placement="top" title="Unidad Detenida"></span>'; ?>
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
                    boxText{{ $device->id }}.innerHTML = '{{$device->name}} - {!! $heading !!} '+ "<br>Fecha: {{ $device->lastpacket->updateTime }}<br> Tiempo Detenido: "+ stopped_time + "<br> Velocidad: {{ $device->lastpacket->speed }} k/h <br> Motor: {!! $motor !!}";

                    @else
                    boxText{{ $device->id }}.innerHTML ='{{$device->name}} - {!! $heading !!} '+ "<br>Fecha: {{ $device->lastpacket->updateTime }}<br> Velocidad: {{ $device->lastpacket->speed }} k/h <br> Motor: {!! $motor !!}";

                    @endif

                           var myOptions = {
                         content: boxText{{ $device->id }}
                        ,disableAutoPan: false
                        ,maxWidth: 0
                        ,pixelOffset: new google.maps.Size(-140, 0)
                        ,zIndex: null
                        ,boxStyle: { 
                          background: "white"
                          ,width: "280px"
                          ,borderRadius:"3px"
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

                    
                        @if($device->engine == 1)

                                var labelText = '{{$device->name}} - {!! $heading !!} '
                                @endif 
                                @if($device->engine == 0)
                                var labelText = '{{$device->name}} - {!! $heading !!} ' 
                        @endif 
                         

                        var myOptionsLabel = {
                             content: labelText
                            ,boxStyle: {
                                background: "white",
                                borderRadius:"3px",
                               border: "1px solid grey",
                              textAlign: "center",
                              opacity:0.75
                              ,fontSize: "8pt"
                              ,width: "100px"
                             }
                            ,disableAutoPan: true
                            ,pixelOffset: new google.maps.Size(-25, 0)
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
                        labelContent: "<div   onclick='showinfo({{$device->id}})'><span class='glyphicon @if($device->dstate_id==1) movement  @endif  glyphicon-circle-arrow-up fa-rotate-{{$device->lastpacket->heading}}' aria-hidden='true'></span> {{$device->name}} @if($device->boxs_id != null) -> {{ $device->boxs->name }} @endif</div><div class='none windowinfo window{{$device->id}}'>Velocidad: <span >{{$device->lastpacket->speed }}</span></div>",
                        labelAnchor: new google.maps.Point(22, 0),
                        labelClass: "labels", // the CSS class for the label
                        labelStyle: {opacity: 0.75},
                        id:{{ $device->id }}
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

       google.maps.event.addListener(markerCluster, "mouseover", function (c) {
          console.log("mouseover: ");
          console.log("&mdash;Center of cluster: " + c.getCenter());
          console.log("&mdash;Number of managed markers in cluster: " + c.getSize());
        });

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
                    function go(id,lat,lng,geofence,dstate_id,speed,device_name,heading,movement,status,EventCode,updateTime,stop_time,stop,odometro,previous_heading){
                        
                        //HEADING
                            $('.move'+id).removeClass('fa-rotate-'+previous_heading)
                            $('.move'+id).addClass('fa-rotate-'+heading)
                            $('.move'+id).addClass('ahora'+heading)
                        //HEADING
                        $('.odometro'+id).html(odometro)
                        if(stop==1){
                            //poner rojo
                            $('.move'+id).removeClass('green')
                            $('.move'+id).addClass('red')
                            $('.move'+id).attr('data-original-title','Unidad detenida n')
                            icon_move =  '<span class="icon-arrow-circle-up move10 leicon red  fa-rotate-'+heading+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidad en Movimiento n"></span>'
                       } 
                        if(stop==0){
                            //poner rojo
                            $('.move'+id).removeClass('red')
                            $('.move'+id).addClass('green')
                            $('.move'+id).addClass('sepusoverde')
                            $('.move'+id).attr('data-original-title','Unidad en Movimiento n')
                            icon_move =  '<span class="icon-arrow-circle-up move10 leicon green  fa-rotate-'+heading+'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Unidad en Movimiento n"></span>'
                        }
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
                           this[buble].setContent(device_name + ' '+icon_move+ '<br> Fecha: '+updateTime+'<br> Tiempo Detenido: '+stop_time+' minutos <br> Velocidad: '+speed+' K/h.')
                        }else{
                           this[buble].setContent(device_name + ' '+icon_move+ '<br> Fecha: '+updateTime+'<br> Velocidad-: '+speed+' K/h.') 
                        }


                        
                        lalabelcontent = device_name + ' ' + icon_move;
                           
                        if(EventCode == 20){
                            $('.engine'+id).removeClass('green')
                            $('.engine'+id).addClass('red')
                            $('.engine'+id).attr('data-original-title','Unidad Apagada')
                            elengine = '<span class="engine'+id+' glyphicon glyphicon-record red" data-toggle="tooltip" data-placement="top" title="Unidad Apagada *"></span>'
                            lalabelcontent = device_name + '*<span class="engine'+id+' glyphicon glyphicon-record red" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>'
                             
                        }
 
                        if(EventCode == 21){
                            $('.engine'+id).removeClass('red')
                            $('.engine'+id).addClass('green') 
                            $('.engine'+id).attr('data-original-title','Unidad Encendida')
                            elengine = '*<span class="engine'+id+' glyphicon glyphicon-record green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida *"></span>'
                            lalabelcontent = device_name + '*<span class="engine'+id+' glyphicon glyphicon-record green" data-toggle="tooltip" data-placement="top" title="Unidad Encendida"></span>'
                            
                        } 
                        this[lalabel].setContent(lalabelcontent)

                        //
                        labelname = 'label'+id
                        myLatlng = new google.maps.LatLng(lat, lng); 
                        this[labelname].setPosition( myLatlng );
                        this[labelname].labelContent = "---<div   onclick='showinfo("+id+")'><span class='glyphicon glyphicon-circle-arrow-up "+ movement_class +" fa-rotate-"+heading+"' aria-hidden='true'></span>"+device_name+" namedevice</div><div class='none windowinfo window"+id+"'>Fecha: "+updateTime+" <br>Velocidad: "+speed+"</div>";
                        this[labelname].label.setContent();

                        this[akaname].setDuration(1000)
                        this[akaname].setEasing('linear');
                        this[akaname].setPosition(myLatlng);
                        $('.speed'+id).html(speed)

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
                        console.log(' ')
                        console.log(data['device_name'])
                        console.log('FROM SERVER',data);
                        go(data['device_id'],data['lat'], data['lng'],data['geofence'],data['dstate_id'],data['Speed'],data['device_name'],data['Heading'],data['movement'],data['status'],data['EventCode'],data['updateTime'],data['stop_time'],data['stop'],data['odometro'],data['previous_heading'])
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
                                console.log(r)
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
                                    console.log(poly_data)
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
                                      "height":'50px'
                                    },
                                    superblues: {
                                      "color": "grey",
                                      "background-color": "white"
                                    }
                                  }
                                });  
                              $.notify(device_name +' '+status_desc+ ' <a class=" goto gotoa " lat="'+llat+'" lng = "'+llng+'" >'+ r.name + '</a>', {
  style: 'happyblues',
  className: 'superblues',
  clickToHide: false,
  autoHideDelay: 30000,
  position: 'bottom right'
});
                        
                                console.log('el go')
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
                        $.notify("COMENZO carga", "info");
                    })
                    socket.on("travel_start<?php echo Auth::user()->client_id  ?>", function(data){
                        
                        $('.device_'+data).removeClass('bg-green')
                        $('.device_'+data).addClass('bg-blue')
                        $('#state_'+data).html('en ruta')
                         
                        $.notify("COMENZO VIAJE", "info");
                    })
                    socket.on("descarga_start<?php echo Auth::user()->client_id  ?>", function(data){
                         
                        $('.device_'+data).removeClass('bg-blue')
                        $('.device_'+data).addClass('bg-purple') 
                        $('#state_'+data).html('descargando')
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
                    .movement{
                        color: green;
                    }
                    .gotoa{ 
                        color: #45a2dc
                    }
                   
.notifyjs-happyblues-superblues {
 
        background-color: #dedede;
    border: 1px solid #c1c1c1;
}
                    </style>