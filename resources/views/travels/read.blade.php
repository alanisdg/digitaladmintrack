    @extends('layouts.master')
    @section('content')
    <div class="container">
        <div class="row mt30">
            <div class="col-md-4">
                <div>
                    <!-- Nav tabs -->
                    <h3> @if(isset($travel->device->name))
                        {{ $travel->device->name }} 
                        @else
                          Sin unidad asignada 
                        @endif  {{ $travel->tstate->name }}

                        @if($travel->tstate_id == 9)
                            {{ $descarga_time }}
                        @endif
                    </h3>  
                    <ul class="nav nav-tabs" role="tablist">
                       <li role="presentation" class="active"><a href="#viaje" aria-controls="viaje" role="tab" data-toggle="tab">Viaje</a></li>
                       <li role="presentation"><a href="#stop" aria-controls="stop" role="tab" data-toggle="tab">Paradas</a></li>
                        <li role="presentation"><a href="#messages" aria-controls="stop" role="tab" data-toggle="tab">Mensajes</a></li> 
                        <li role="presentation"><a href="#stop_engine_tab" aria-controls="stop" role="tab" data-toggle="tab">Motor</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="viaje">
                        <!--VIAJE-->
                        
                        <ul class="list-group">
                            <li class="list-group-item">
                             @if(isset($travel->route->name))
                             <b>Ruta: </b>{{ $travel->route->name }}
                             @else
                             <b>Ruta:<b> Sin ruta asignada
                             @endif
                            </li>
                            <li class="list-group-item"><b>Duración del viaje:</b> {{ $total_travel }}</li>
                            @if($max =='')
                            <li class="list-group-item"><b>Máximo periodo detenido:</b>No Disponible</li>

                            @else
                            <li class="list-group-item"><b>Máximo periodo detenido:</b> <span class="goto" lat="{{ $max[0] }}" lng="{{ $max[1] }}">{{ $max[2] }}</span></li>
                            @endif
                            <li class="list-group-item">
                                @if(isset($travel->driver->name))
                                <b>Chofer:</b> {{ $travel->driver->name }}
                                @else
                                <b>Chofer:</b> Sin chofer asignado
                                @endif 
                            </li>
                            {!! $title !!}
                            
                                <li class="list-group-item">
                                <p>CARGA</p>
                                <p><b>Hora prevista de Salida</b> {{ $travel->departure_date }}</p>
                                <p><b>Hora de llegada a origen</b> {{ $origin_arrival_time }}</p>
                                @if(isset($real_departure))
                                
                                    <p><b>Hora de Salida</b> {{ $real_departure }}</p>
                                    <p><b>Tiempo de carga:</b> <span class="badge ">{{ $carga }}</span></p>
                                
                                @endif
                                </li>
                                

                                <li class="list-group-item">
                                <p>DESCARGA</p>
                                <p><b>Hora prevista de llegada</b> {{ $travel->arrival_date }}</p>
                                <p><b>Hora de llegada a destino</b> {{ $destination_arrival_time }}</p>
                                @if(isset($real_arrival))
                                    <p><b>Hora de Salida</b> {{ $real_arrival }}</p>
                                    <p><b>Tiempo de descarga:</b> <span class="badge ">{{ $descarga }}</span></p>
                                @endif 
                                </li>
                                
                        </ul>
                        <!--VIAJE-->
                       </div>
                    <div role="tabpanel" class="tab-pane" id="stop">
                    <ul class="list-group">
                        @foreach($map_info as $key => $stop) 
                            <li class="list-group-item">
                                Detenido por <span class="goto" lat="{{ $stop[0] }}" lng="{{ $stop[1] }}">{{ $stop[2] }} - {{ $stop[3] }}</span>
                            </li>  
                    
                        @endforeach
                        </ul> 
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages"><h4>Comentarios</h4>
            @foreach($comments as $comment)
            <div class="comment">
                <span class="comment_name">{{ $comment->user->name }}</span>
                <span class="comment_text">{{ $comment->comment }}</span>
                <p class="comment_date">{{ $comment->created_at }}</p>
            </div>
 
            @endforeach
            <div class="comment_live">

            </div>
            <form class="post_comment" action="comments/post" method="post">
                <input type="text"   class="comment_box" id="comment" placeholder="Escribe un comentario... "name="comment" value="">
                <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" id="travel_id" name="user_id" value="{{ $travel->id }}">
                <input type="hidden" id="tcode_id" name="user_id" value="{{ $travel->tcode->id }}">
                <input class="btn btn-sm btn-primary" type="submit" name="" value="comentar">
            </form></div>
            <div role="tabpanel" class="tab-pane" id="stop_engine_tab">
                    {!! $stop_parse !!} t
                    </div>
                  </div>
                </div>
<div class="form-group">
                             <label  class="control-label"><img src="/images/stop.png"></label>
                            <input type="checkbox" id="stopr" checked>
                             <label  class="control-label"><img src="/images/stop_engine.png"></label>
                            <input type="checkbox" id="stop_by_engine" checked>
                        </div>
                        
                     
        </div>
        <div class="col-md-8 comments">
            <div id="map" style="height: 600px" ></div>
        </div>
        <div class="col-md-12" style="margin-top: 30px">
            <h3><b>Reportes</b></h3>

            <table class="table table-striped">
                {!! $head !!}
                <tbody>
                    {!! $body !!}
                </tbody>
            </table>


        </div>
    </div>
    </div>
<style type="text/css"> 
.container_mwl{
    background: red
}
.labelClass:hover { 
   opacity: 1.0 !important;
   background: blue !important;
}
    .map-icon-label .map-icon {
    font-size: 24px;
    color: #FFFFFF;
    line-height: 48px;
    text-align: center;
    white-space: nowrap;
}
</style>
    @endsection
    @section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
    <script src="/js/travels.js"></script>
    <script type="text/javascript">
    var myLatlng = new google.maps.LatLng(25.674873, -100.318432);
var mapOptions = {
    zoom: 5,
    center: myLatlng,
    mapTypeControl:true,
    zoomControl: true,
    scaleControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
}
map = new google.maps.Map(document.getElementById('map'), mapOptions);
    $('.datepicker').datepicker({
        todayHighlight: true,
        autoclose:true
    }); 
    
    $('.goto').click(function(){
                            console.log('goto')
                            console.log($(this).attr('lat'))
                            console.log($(this).attr('lng'))
                            map.setZoom(15);
                            map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                            console.log('arriba')
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            c = new google.maps.LatLng($(this).attr('lat'),$(this).attr('lng'))
                          


                        })
    lines = []
    var infowindow =  new google.maps.InfoWindow({
        content: ''
    });

    stp = []
            stp_engine = []
    <?php foreach ($od_geofences as $geofence) {
        if($geofence->type=='circle'){
            ?>

            l = parseFloat(<?php echo $geofence->lat ?>)
        ln = parseFloat(<?php echo $geofence->lng ?>)
        draw_circle = new google.maps.Circle({
            center: {lat: l, lng: ln},
            radius: <?php echo $geofence->radius ?>,
            strokeColor: "#cccccc",
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: '<?php echo $geofence->color ?>',
            fillOpacity: 0.45,
            zIndex: 1,
            map: map
        })

        var myLatlng= new google.maps.LatLng(l,ln );
        var label= new MarkerWithLabel({
            position: myLatlng,
            map: map,
            icon: " ",
            labelContent: "<div><?php echo $geofence->name ?></div>",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            zIndex: -1
        }); 


        <?php
        }else{
            echo json_encode($geofence->poly_data,true);
            ?>

            var poly_data = JSON.parse(<?php  echo json_encode($geofence->poly_data,true) ?>);
            var myLatlng= new google.maps.LatLng(poly_data[0].lat,poly_data[0].lng );
        var label= new MarkerWithLabel({
            position: myLatlng,
            map: map,
            icon: " ",
            labelContent: "<div><?php echo $geofence->name ?></div>",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            zIndex: -1
        });
       
        var draw_circle = new google.maps.Polygon({
            paths: poly_data,
            fillColor: '<?php echo $geofence->color?>',
            strokeWeight: 0,
            fillOpacity: 0.35,
            map: map,
            zIndex: -1
          });


            <?php
        }
        ?>

        


        <?php
    }?>
     <?php 
            foreach($map_info as $key => $stop){ ?> 
                    lat = <?php echo  $stop[0] ?>;
                    lng = <?php echo $stop[1] ?>;
                    time = <?php echo "'".$stop[2]."'" ?>;
                    de = <?php echo "'".$stop[3]."'" ?>;
                    a = <?php echo "'".$stop[4]."'" ?>;
                    c = new google.maps.LatLng(lat,lng)

                    var stop_marker = new google.maps.Marker({
                    title: time,
                    position: c,
                    icon:'/images/stop.png',
                    map: map
                    });
                    stp.push(stop_marker)

                    bindInfoWindow(stop_marker, map, infowindow, "<p>Tiempo detenido: " + time + "</p><p>de:"+de+" <br> a:" + a);


                    


           <?php  } ?>

           <?php 
            foreach($bad_engine as $key => $stop){ ?> 
                console.log('va')
                    lat = <?php echo  $stop[0] ?>;
                    lng = <?php echo $stop[1] ?>;
                    time = <?php echo "'".$stop[2]."'" ?>;
                    tiempo = <?php echo "'".$stop[3]."'" ?>;
                    de = <?php echo "'".$stop[4]."'" ?>;
                    a = <?php echo "'".$stop[5]."'" ?>;
                    c = new google.maps.LatLng(lat,lng)

                    if(time > 15){
                     c = new google.maps.LatLng(lat,lng)
                    var stop_marker = new google.maps.Marker({
                        title: "<p>Tiempo detenido: " + tiempo + "</p><p>de :"+de+" <br> a:" + a,
                        position: c,
                        icon:'/images/stop_engine.png',
                        map: map
                        });
                    stp_engine.push(stop_marker)
                    bindInfoWindow(stop_marker, map, infowindow, "<p>Tiempo detenido: " + tiempo + "</p><p>de :"+de+" <br> a:" + a);
                }


                   


                    


           <?php  } ?>



    points = <?php echo json_encode($points) ?>;
    console.log(points);
    limit = points.length -1

    var infowindow =  new google.maps.InfoWindow({
        content: ''
    });
    ko = 0

                for (f = 0; f < points.length; f++) { 

                    /***  **/
                    lat = points[f].lat;
                    lng = points[f].lng;
                    c = new google.maps.LatLng(lat,lng)
                    if(ko == 0){
                        icon = '/images/start-flag.png';
                    }else{
                        icon = '/images/dot.png';
                    }
                    
                    if(points.length -1 == f){
                     icon = '/images/finish.png';
                    }else{
                     //something else.
                    }
                    ko++;
                   
                    var marker = new google.maps.Marker({
                    title: 'el titulo',
                    position: c,
                    icon:icon,
                    map: map
                    }); 

                    bindInfoWindow(marker, map, infowindow, "<p>Fecha:" + points[f].updateTime + "</p>"+"<p>Velocidad:" + points[f].speed + " k/h</p>");  
                     

                    /*
                    var marker = new MarkerWithLabel({
                          position: c,
                          map: map,
                          opacity: 1,
                          labelContent: "<div ide='"+points[f].id+"' class='point_go aca"+points[f].id+"' style='opacity:0' >"+points[f].updateTime+"</div>",
                          labelClass: "labelClass" // the CSS class for the label
                    }); */


                    /**/
                    next = f+1;
                    if(f != limit){
                     var flightPlanCoordinates = [
                    {lat: points[f].lat, lng: points[f].lng },
                    {lat: points[next].lat, lng: points[next].lng}
                    ];
                    var lineSymbols = {
          path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
        };
                    color = getColor(points[f].speed)
                            if(points[f].rssi < -90){
                               
                        var flightPath = new google.maps.Polyline({
                      path: flightPlanCoordinates,
                      geodesic: true,
                      icons: [{
            icon: lineSymbols,
            offset: '100%'
          }],
                      strokeColor: color,
                      strokeOpacity: 1.0,
                      strokeWeight: 2
                    });
                    }else{
                      var flightPath = new google.maps.Polyline({
                      path: flightPlanCoordinates,
                      geodesic: true,
                      icons: [{
            icon: lineSymbols,
            offset: '0',
            repeat: '20px'
          }],
                      strokeColor: color,
                      strokeOpacity: 1.0,
                      strokeWeight: 2
                    });  
                    }
                    

                    flightPath.setMap(map);
                    lines.push(flightPath)

                    }
                     
                }

                function bindInfoWindow(marker, map, infowindow, html) { 
                    google.maps.event.addListener(marker, 'click', function() { 
                        infowindow.setContent(html); 
                        infowindow.open(map, marker); 
                    }); 
                } 



                function getColor(speed){
                    if(speed <= 5){
                        return '#f00'
                    }
                    if(speed <= 20){
                        return '#ff3f3f'
                    }
                    if(speed <= 40){
                        return '#ff8a00'
                    }
                    if(speed <= 60){
                        return '#ffa131'
                    }
                    if(speed <= 70){
                        return '#7d83ff'
                    }
                    if(speed <= 80){
                        return '#4e56f7'
                    }
                    if(speed > 80){
                        return '#010abd'
                    }
                    
                }
$(document).ready(function(){
    $('.point_go').hover(function(){
        console.log('hover')
        console.log($(this).attr('ide'))
    })
    $('.labelClass').hover(function(){
       
        $(this).css('border','1px solid red')
        $(this).next('.aca').css('opacity',1)
                        console.log('estas bien hover')
                    })
})
    
                  


    $('.post_comment').submit(function(){
        $.ajax({
            url:'/comments/post',
            type:'POST', 
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { comment: $('#comment').val(),user_id: $('#user_id').val(),travel_id: $('#travel_id').val(),tcode_id: $('#tcode_id').val()  },
            success: function(r){
                console.log(r['user'])
                $('.comment_box').val('')
                $('.comment_live').append('<div class="comment"><span class="comment_name">'+r['user'].name+' </span><span class="comment_text">'+r['comment'].comment+'</span><p class="comment_date">'+r['comment'].created_at+'</p></div>')


            },
            error: function(data){

            }
        })
        return false;
    })
$('#stopr').click(function(){
    console.log('stop')
    if( $(this).is(':checked') == true){
        //mostrar
        $.each(stp,function(a,marker){
        marker.setVisible(true)
        }) 
    }else{
       //esconder
       $.each(stp,function(a,marker){
        marker.setVisible(false)
        }) 
    }
    console.log(stp)

})

$('#stop_by_engine').click(function(){
    console.log('stop')
    if( $(this).is(':checked') == true){
        //mostrar
        $.each(stp_engine,function(a,marker){
        marker.setVisible(true)
        }) 
    }else{
       //esconder
       $.each(stp_engine,function(a,marker){
        marker.setVisible(false)
        }) 
    } 

})
    </script>
    <script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
    @endsection
