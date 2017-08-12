@extends('layouts.tracking')
@section('content')
<style media="screen">
.progress{
    border-radius: 0 !important;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 " style="margin-top:100px">
            <div class="panel panel-default">
                <div class="panel-heading">


                    <p>Estado del viaje: {{ $travel->tstate->name }}</p>
                    <p>Estado del viaje: {{ $travel->tstate_id }}</p>
                    <p>Estado del viaje: {{ $travel->id }}</p>
                    <p>Hora de Salida: {{ $real_departure  }}</p>
                    <p>Hora de Llegada: {{ $real_arrival  }}</p>
                    <p>Origen: {{ $travel->route->origin->name }}</p>
                    <p>Destino: {{ $travel->route->destination->name }}</p>

                    @if($travel->actual_id==null)
                    <p>Geocerca Actual: {{ $travel->route->origin->name }}</p>
                    @else

                    <p>Salio de: {{ $travel->actual->name }}</p>
                    @endif
                    <div class="container_references">
                        <div class="reference_tracking">

                            {{ $travel->route->origin->name }}
                            <div class="progress">

                                <?php if($travel->actual_id != null){
                                    $percent = 100;
                                }else{
                                    $percent = $travel->percent;
                                }
                                ?>
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div>
                        <?php $d=0;
                        $len = count($geofences);
                        $to = $len-1;?>
                        @foreach($geofences as $key => $geofence)
                        <?php  $d++; ?>
                        <div class="reference_tracking">
                            <- {{ $geofence->name }} ->
                            <?php


                            if ($key == $to) {
                                echo $travel->route->destination->name;
                            }


                            $percent = false;

                             foreach($hits as $key => $hit){
                                 $geofence->id;
                                
                                 if($geofence->id == $travel->actual->id){
                                    $percent = $travel->percent;
                                }

                                if($hit->geofence->id == $geofence->id AND $geofence->id != $travel->actual->id){
                                    $percent = 100;
                                }
                               

                             }


                             /*
                             $percent = false;
                              foreach($hits as $hit){
                                  echo $hit->geofence->name . " - " . $travel->actual->id;
                                  if($hit->geofence->id == $travel->actual->id){
                                      echo "no existe actual";
                                      $percent = $travel->percent;

                                  }else{
                                      $percent = 100;
                                  }
                              }
                              if($percent == false){
                                  $percent=0;
                              }
                             */
                                 ?>
                            <div class="progress">


                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percent; ?>%;">
                                    <?php echo $percent; ?>% Complete
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <?php  $d = $d+1 ?>
                    </div>
                    <div style="clear:both">

                    </div>
                </div>
            </div>







            <div class="row">
                <h2>Historial de Viaje</h2>
                <div class="timeline timeline-single-column">
                    @if($real_departure != 'Pendiente')
                    <span class="timeline-label">
                        <span class="label label-info ">Salida</span>
                    </span>
                    <div class="timeline-item">
                        <div class="timeline-point timeline-point-success">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="timeline-event timeline-event-success">
                            <div class="timeline-heading">
                                <h4>Comenzo Ruta</h4>
                            </div>
                            <div class="timeline-body">
                                <p>Salio de {{ $travel->route->origin->name }} </p>
                            </div>
                            <div class="timeline-footer primary">
                                <p class="text-right">{{ $real_departure }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @foreach($hits as $hit)
                    <span class="timeline-label">
                        <span class="label label-info ">Salida</span>
                    </span>
                    <div class="timeline-item">
                        <div class="timeline-point timeline-point-success">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="timeline-event timeline-event-success">
                            <div class="timeline-heading">
                                <h5>Salio de {{ $hit->geofence->name }} </h5><p class="text-right">{{ $hit->packet->id }} - {{ $hit->packet->devices_id }} - {{ $hit->packet->updateTime }}</p>
                            </div>


                        </div>
                    </div>
                    @endforeach
                    @if($real_arrival != 'Pendiente')
                    <span class="timeline-label">
                        <span class="label label-info ">Llegada</span>
                    </span>
                    <div class="timeline-item">
                        <div class="timeline-point timeline-point-info">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="timeline-event timeline-event-info">
                            <div class="timeline-heading">
                                <h4>Termino Viaje</h4>
                            </div>
                            <div class="timeline-body">
                                <p>LLego a {{ $travel->route->destination->name }} </p>
                            </div>
                            <div class="timeline-footer primary">
                                <p class="text-right">{{ $real_arrival }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    <span class="timeline-label">
                        <button class="btn btn-danger"><i class="fa fa-ambulance"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div id="map"></div>
    <div id="right-panel">
        <div>
            <b>Start:</b>
            <select id="start">
                <option value="25.816171, -100.245228">Halifax, NS</option>
                <option value="Boston, MA">Boston, MA</option>
                <option value="New York, NY">New York, NY</option>
                <option value="Miami, FL">Miami, FL</option>
            </select>
            <br>

            <br>
            <b>End:</b>
            <select id="end">
                <option value="Vancouver, BC">Vancouver, BC</option>
                <option value="Seattle, WA">Seattle, WA</option>
                <option value="San Francisco, CA">San Francisco, CA</option>
                <option value="Los Angeles, CA">Los Angeles, CA</option>
            </select>
            <br>
            <input type="submit" id="submit">
        </div>
        <div id="directions-panel"></div>
    </div>


    <script src="/js/travels.js"></script>
    <style media="screen">
    .reference_tracking{
        border-right: 1px solid #4eaaf1;
        float: left;
    }
    .container_references{

    }
    </style>
    <script type="text/javascript">
    w = 100 /{{ $d }};
    console.log(w)
    $('.reference_tracking').css('width',w+'%')
    </script>

    <script>
    function initMap() {
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: {lat: 41.85, lng: -87.65}
        });
        directionsDisplay.setMap(map);

        document.getElementById('submit').addEventListener('click', function() {
            calculateAndDisplayRoute(directionsService, directionsDisplay);
        });

        @foreach($geofences_route as $geofence_route)
        calculateAndDisplayRoute(directionsService, directionsDisplay)
        @endforeach


    }


    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        directionsService.route({
            origin: document.getElementById('start').value,
            destination: document.getElementById('end').value,
            optimizeWaypoints: true,
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];
                console.log(route.legs[0].distance.value)
            }
        });
    }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw&callback=initMap">
    @endsection
    <style media="screen">
    .timeline {
        width: 100%;
        position: relative;
        padding: 1px 0;
        list-style: none;
        font-weight: 300;
    }
    .timeline .timeline-item {
        padding-left: 0;
        padding-right: 30px;
    }
    .timeline .timeline-item.timeline-item-right,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) {
        padding-left: 30px;
        padding-right: 0;
    }
    .timeline .timeline-item .timeline-event {
        width: 100%;
    }
    .timeline:before {
        border-right-style: solid;
    }
    .timeline:before,
    .timeline:after {
        content: " ";
        display: block;
    }
    .timeline:after {
        clear: both;
    }
    .timeline:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 50%;
        height: 100% !important;
        margin-left: 1px;
        border-right-width: 2px;
        border-right-style: solid;
        border-right-color: #888888;
    }
    .timeline.timeline-single-column.timeline {
        width: 100%;
        max-width: 768px;
    }
    .timeline.timeline-single-column.timeline .timeline-item {
        padding-left: 72px;
        padding-right: 0;
    }
    .timeline.timeline-single-column.timeline .timeline-item.timeline-item-right,
    .timeline.timeline-single-column.timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) {
        padding-left: 72px;
        padding-right: 0;
    }
    .timeline.timeline-single-column.timeline .timeline-item .timeline-event {
        width: 100%;
    }
    .timeline.timeline-single-column.timeline:before {
        left: 42px;
        width: 0;
        margin-left: -1px;
    }
    .timeline.timeline-single-column.timeline .timeline-item {
        width: 100%;
        margin-bottom: 20px;
    }
    .timeline.timeline-single-column.timeline .timeline-item:nth-of-type(even) {
        margin-top: 0;
    }
    .timeline.timeline-single-column.timeline .timeline-item > .timeline-event {
        float: right !important;
    }
    .timeline.timeline-single-column.timeline .timeline-item > .timeline-event:before,
    .timeline.timeline-single-column.timeline .timeline-item > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline.timeline-single-column.timeline .timeline-item > .timeline-event:before {
        left: -15px !important;
        border-right-width: 15px !important;
    }
    .timeline.timeline-single-column.timeline .timeline-item > .timeline-event:after {
        left: -14px !important;
        border-right-width: 14px !important;
    }
    .timeline.timeline-single-column.timeline .timeline-item > .timeline-point {
        transform: translateX(-50%);
        left: 42px !important;
        margin-left: 0;
    }
    .timeline.timeline-single-column.timeline .timeline-label {
        transform: translateX(-50%);
        margin: 0 0 20px 42px;
    }
    .timeline.timeline-single-column.timeline .timeline-label + .timeline-item + .timeline-item {
        margin-top: 0;
    }
    .timeline.timeline-line-solid:before {
        border-right-style: solid;
    }
    .timeline.timeline-line-dotted:before {
        border-right-style: dotted;
    }
    .timeline.timeline-line-dashed:before {
        border-right-style: dashed;
    }
    .timeline .timeline-item {
        position: relative;
        float: left;
        clear: left;
        width: 50%;
        margin-bottom: 20px;
    }
    .timeline .timeline-item:before,
    .timeline .timeline-item:after {
        content: "";
        display: table;
    }
    .timeline .timeline-item:after {
        clear: both;
    }
    .timeline .timeline-item:last-child {
        margin-bottom: 0 !important;
    }
    .timeline .timeline-item.timeline-item-right > .timeline-event,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-event {
        float: right !important;
    }
    .timeline .timeline-item.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before,
    .timeline .timeline-item.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline .timeline-item.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before {
        left: -15px !important;
        border-right-width: 15px !important;
    }
    .timeline .timeline-item.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        left: -14px !important;
        border-right-width: 14px !important;
    }
    .timeline .timeline-item > .timeline-event:before {
        top: 10px;
        right: -15px;
        border-top: 15px solid transparent;
        border-left-width: 15px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 15px solid transparent;
    }
    .timeline .timeline-item > .timeline-event:after {
        top: 11px;
        right: -14px;
        border-top: 14px solid transparent;
        border-left-width: 14px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 14px solid transparent;
    }
    .timeline .timeline-item > .timeline-point {
        top: 25px;
    }
    .timeline-single-column.timeline .timeline-item > .timeline-event {
        float: right !important;
    }
    .timeline-single-column.timeline .timeline-item > .timeline-event:before,
    .timeline-single-column.timeline .timeline-item > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline-single-column.timeline .timeline-item > .timeline-event:before {
        left: -15px !important;
        border-right-width: 15px !important;
    }
    .timeline-single-column.timeline .timeline-item > .timeline-event:after {
        left: -14px !important;
        border-right-width: 14px !important;
    }
    .timeline .timeline-item:nth-of-type(2) {
        margin-top: 40px;
    }
    .timeline .timeline-item.timeline-item-left,
    .timeline .timeline-item.timeline-item-right {
        clear: both !important;
    }
    .timeline .timeline-item.timeline-item-right,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) {
        float: right;
        clear: right;
    }
    .timeline .timeline-item.timeline-item-right > .timeline-point,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-point {
        left: -24px;
    }
    .timeline .timeline-item.timeline-item-right > .timeline-point.timeline-point-blank,
    .timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) > .timeline-point.timeline-point-blank {
        left: -12px;
    }
    .timeline .timeline-item.timeline-item-arrow-sm.timeline-item-right > .timeline-event,
    .timeline .timeline-item.timeline-item-arrow-sm:nth-of-type(even):not(.timeline-item-left) > .timeline-event {
        float: right !important;
    }
    .timeline .timeline-item.timeline-item-arrow-sm.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-sm:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-sm.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item.timeline-item-arrow-sm:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline .timeline-item.timeline-item-arrow-sm.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-sm:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before {
        left: -10px !important;
        border-right-width: 10px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-sm.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item.timeline-item-arrow-sm:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        left: -9px !important;
        border-right-width: 9px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-sm > .timeline-event:before {
        top: 4px;
        right: -10px;
        border-top: 10px solid transparent;
        border-left-width: 10px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 10px solid transparent;
    }
    .timeline .timeline-item.timeline-item-arrow-sm > .timeline-event:after {
        top: 5px;
        right: -9px;
        border-top: 9px solid transparent;
        border-left-width: 9px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 9px solid transparent;
    }
    .timeline .timeline-item.timeline-item-arrow-sm > .timeline-point {
        top: 14px;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-sm > .timeline-event {
        float: right !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-sm > .timeline-event:before,
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-sm > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-sm > .timeline-event:before {
        left: -10px !important;
        border-right-width: 10px !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-sm > .timeline-event:after {
        left: -9px !important;
        border-right-width: 9px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-md.timeline-item-right > .timeline-event,
    .timeline .timeline-item.timeline-item-arrow-md:nth-of-type(even):not(.timeline-item-left) > .timeline-event {
        float: right !important;
    }
    .timeline .timeline-item.timeline-item-arrow-md.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-md:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-md.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item.timeline-item-arrow-md:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline .timeline-item.timeline-item-arrow-md.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-md:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before {
        left: -15px !important;
        border-right-width: 15px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-md.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item.timeline-item-arrow-md:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        left: -14px !important;
        border-right-width: 14px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-md > .timeline-event:before {
        top: 10px;
        right: -15px;
        border-top: 15px solid transparent;
        border-left-width: 15px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 15px solid transparent;
    }
    .timeline .timeline-item.timeline-item-arrow-md > .timeline-event:after {
        top: 11px;
        right: -14px;
        border-top: 14px solid transparent;
        border-left-width: 14px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 14px solid transparent;
    }
    .timeline .timeline-item.timeline-item-arrow-md > .timeline-point {
        top: 25px;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-md > .timeline-event {
        float: right !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-md > .timeline-event:before,
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-md > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-md > .timeline-event:before {
        left: -15px !important;
        border-right-width: 15px !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-md > .timeline-event:after {
        left: -14px !important;
        border-right-width: 14px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-lg.timeline-item-right > .timeline-event,
    .timeline .timeline-item.timeline-item-arrow-lg:nth-of-type(even):not(.timeline-item-left) > .timeline-event {
        float: right !important;
    }
    .timeline .timeline-item.timeline-item-arrow-lg.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-lg:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-lg.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item.timeline-item-arrow-lg:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline .timeline-item.timeline-item-arrow-lg.timeline-item-right > .timeline-event:before,
    .timeline .timeline-item.timeline-item-arrow-lg:nth-of-type(even):not(.timeline-item-left) > .timeline-event:before {
        left: -18px !important;
        border-right-width: 18px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-lg.timeline-item-right > .timeline-event:after,
    .timeline .timeline-item.timeline-item-arrow-lg:nth-of-type(even):not(.timeline-item-left) > .timeline-event:after {
        left: -17px !important;
        border-right-width: 17px !important;
    }
    .timeline .timeline-item.timeline-item-arrow-lg > .timeline-event:before {
        top: 10px;
        right: -18px;
        border-top: 18px solid transparent;
        border-left-width: 18px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 18px solid transparent;
    }
    .timeline .timeline-item.timeline-item-arrow-lg > .timeline-event:after {
        top: 11px;
        right: -17px;
        border-top: 17px solid transparent;
        border-left-width: 17px;
        border-left-style: solid;
        border-right-width: 0;
        border-right-style: solid;
        border-bottom: 17px solid transparent;
    }
    .timeline .timeline-item.timeline-item-arrow-lg > .timeline-point {
        top: 28px;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-lg > .timeline-event {
        float: right !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-lg > .timeline-event:before,
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-lg > .timeline-event:after {
        right: auto !important;
        border-left-width: 0 !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-lg > .timeline-event:before {
        left: -18px !important;
        border-right-width: 18px !important;
    }
    .timeline-single-column.timeline .timeline-item.timeline-item-arrow-lg > .timeline-event:after {
        left: -17px !important;
        border-right-width: 17px !important;
    }
    .timeline .timeline-item > .timeline-event {
        background: #fff;
        border: 1px solid #888888;
        color: #555;
        position: relative;
        float: left;
        border-radius: 3px;
    }
    .timeline .timeline-item > .timeline-event:before {
        border-left-color: #888888;
        border-right-color: #888888;
    }
    .timeline .timeline-item > .timeline-event:after {
        border-left-color: #fff;
        border-right-color: #fff;
    }
    .timeline .timeline-item > .timeline-event * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-default {
        background: #fff;
        border: 1px solid #888888;
        color: #555;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-default:before {
        border-left-color: #888888;
        border-right-color: #888888;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-default:after {
        border-left-color: #fff;
        border-right-color: #fff;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-default * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-primary {
        background: #f5f5f5;
        border: 1px solid #888888;
        color: #555;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-primary:before {
        border-left-color: #888888;
        border-right-color: #888888;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-primary:after {
        border-left-color: #f5f5f5;
        border-right-color: #f5f5f5;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-primary * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-success {
        background: #F3F8ED;
        border: 1px solid #72b92e;
        color: #3F8100;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-success:before {
        border-left-color: #72b92e;
        border-right-color: #72b92e;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-success:after {
        border-left-color: #F3F8ED;
        border-right-color: #F3F8ED;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-success * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-info {
        background: #F0F8FD;
        border: 1px solid #3e93cf;
        color: #0062A7;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-info:before {
        border-left-color: #3e93cf;
        border-right-color: #3e93cf;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-info:after {
        border-left-color: #F0F8FD;
        border-right-color: #F0F8FD;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-info * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-warning {
        background: #FFF9E9;
        border: 1px solid #d0aa42;
        color: #ac7e00;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-warning:before {
        border-left-color: #d0aa42;
        border-right-color: #d0aa42;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-warning:after {
        border-left-color: #FFF9E9;
        border-right-color: #FFF9E9;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-warning * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-danger {
        background: #FFC4BC;
        border: 1px solid #d25a4b;
        color: #B71500;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-danger:before {
        border-left-color: #d25a4b;
        border-right-color: #d25a4b;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-danger:after {
        border-left-color: #FFC4BC;
        border-right-color: #FFC4BC;
    }
    .timeline .timeline-item > .timeline-event.timeline-event-danger * {
        color: inherit;
    }
    .timeline .timeline-item > .timeline-event:before,
    .timeline .timeline-item > .timeline-event:after {
        content: "";
        display: inline-block;
        position: absolute;
    }
    .timeline .timeline-item > .timeline-event .timeline-heading,
    .timeline .timeline-item > .timeline-event .timeline-body,
    .timeline .timeline-item > .timeline-event .timeline-footer {
        padding: 4px 10px;
    }
    .timeline .timeline-item > .timeline-event .timeline-heading p,
    .timeline .timeline-item > .timeline-event .timeline-body p,
    .timeline .timeline-item > .timeline-event .timeline-footer p,
    .timeline .timeline-item > .timeline-event .timeline-heading ul,
    .timeline .timeline-item > .timeline-event .timeline-body ul,
    .timeline .timeline-item > .timeline-event .timeline-footer ul {
        margin-bottom: 0;
    }
    .timeline .timeline-item > .timeline-event .timeline-heading h4 {
        font-weight: 400;
    }
    .timeline .timeline-item > .timeline-event .timeline-footer a {
        cursor: pointer;
        text-decoration: none;
    }
    .timeline .timeline-item > .timeline-event .panel,
    .timeline .timeline-item > .timeline-event .table,
    .timeline .timeline-item > .timeline-event .blankslate {
        margin: 0;
        border: none;
        border-radius: inherit;
        overflow: hidden;
    }
    .timeline .timeline-item > .timeline-event .table th {
        border-top: 0;
    }
    .timeline .timeline-item > .timeline-point {
        color: #888888;
        background: #fff;
        right: -24px;
        width: 24px;
        height: 24px;
        margin-top: -12px;
        margin-left: 12px;
        margin-right: 12px;
        position: absolute;
        z-index: 100;
        border-width: 2px;
        border-style: solid;
        border-radius: 100%;
        line-height: 20px;
        text-align: center;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-blank {
        right: -12px;
        width: 12px;
        height: 12px;
        margin-top: -6px;
        margin-left: 6px;
        margin-right: 6px;
        color: #888888;
        background: #888888;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-default {
        color: #888888;
        background: #fff;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-primary {
        color: #888888;
        background: #fff;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-success {
        color: #72b92e;
        background: #fff;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-info {
        color: #3e93cf;
        background: #fff;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-warning {
        color: #d0aa42;
        background: #fff;
    }
    .timeline .timeline-item > .timeline-point.timeline-point-danger {
        color: #d25a4b;
        background: #fff;
    }
    .timeline .timeline-label {
        position: relative;
        float: left;
        clear: left;
        width: 50%;
        margin-bottom: 20px;
        top: 1px;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        padding: 0;
        text-align: center;
    }
    .timeline .timeline-label:before,
    .timeline .timeline-label:after {
        content: "";
        display: table;
    }
    .timeline .timeline-label:after {
        clear: both;
    }
    .timeline .timeline-label:last-child {
        margin-bottom: 0 !important;
    }
    .timeline .timeline-label + .timeline-item {
        margin-top: 0;
    }
    .timeline .timeline-label + .timeline-item + .timeline-item {
        margin-top: 40px;
    }
    .timeline .timeline-label .label-default {
        background-color: #888888;
    }
    .timeline .timeline-label .label-primary {
        background-color: #888888;
    }
    .timeline .timeline-label .label-info {
        background-color: #3e93cf;
    }
    .timeline .timeline-label .label-warning {
        background-color: #d0aa42;
    }
    .timeline .timeline-label .label-danger {
        background-color: #d25a4b;
    }
    @media (max-width: 768px) {
        .timeline.timeline {
            width: 100%;
            max-width: 100%;
        }
        .timeline.timeline .timeline-item {
            padding-left: 72px;
            padding-right: 0;
        }
        .timeline.timeline .timeline-item.timeline-item-right,
        .timeline.timeline .timeline-item:nth-of-type(even):not(.timeline-item-left) {
            padding-left: 72px;
            padding-right: 0;
        }
        .timeline.timeline .timeline-item .timeline-event {
            width: 100%;
        }
        .timeline.timeline:before {
            left: 42px;
            width: 0;
            margin-left: -1px;
        }
        .timeline.timeline .timeline-item {
            width: 100%;
            margin-bottom: 20px;
        }
        .timeline.timeline .timeline-item:nth-of-type(even) {
            margin-top: 0;
        }
        .timeline.timeline .timeline-item > .timeline-event {
            float: right !important;
        }
        .timeline.timeline .timeline-item > .timeline-event:before,
        .timeline.timeline .timeline-item > .timeline-event:after {
            right: auto !important;
            border-left-width: 0 !important;
        }
        .timeline.timeline .timeline-item > .timeline-event:before {
            left: -15px !important;
            border-right-width: 15px !important;
        }
        .timeline.timeline .timeline-item > .timeline-event:after {
            left: -14px !important;
            border-right-width: 14px !important;
        }
        .timeline.timeline .timeline-item > .timeline-point {
            transform: translateX(-50%);
            left: 42px !important;
            margin-left: 0;
        }
        .timeline.timeline .timeline-label {
            transform: translateX(-50%);
            margin: 0 0 20px 42px;
        }
        .timeline.timeline .timeline-label + .timeline-item + .timeline-item {
            margin-top: 0;
        }
    }
    </style>
    <style>
    #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
    }

    #right-panel select, #right-panel input {
        font-size: 15px;
    }

    #right-panel select {
        width: 100%;
    }

    #right-panel i {
        font-size: 12px;
    }
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    #map {
        height: 100%;
        float: left;
        width: 70%;
        height: 100%;
    }
    #right-panel {
        margin: 20px;
        border-width: 2px;
        width: 20%;
        height: 400px;
        float: left;
        text-align: left;
        padding-top: 0;
    }
    #directions-panel {
        margin-top: 10px;
        background-color: #FFEE77;
        padding: 10px;
    }
    </style>
