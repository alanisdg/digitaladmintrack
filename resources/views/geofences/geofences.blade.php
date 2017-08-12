@extends('layouts.master')
@section('content')




<style type="text/css">
      #map, html, body {
        padding: 0;
        margin: 0;
        height: 100%;
      }
      #panel {
        width: 200px;
        font-family: Arial, sans-serif;
        font-size: 13px;
        float: right;
        margin: 10px;
      }
      #color-palette {
        clear: both;
      }
      .color-button {
        width: 14px;
        height: 14px;
        font-size: 0;
        margin: 2px;
        float: left;
        cursor: pointer;
      }
      #delete-button {
      }
    </style>
<div class="mt10 page-content inset">
    <div class="row">
        <div class="col-md-4">
            <div class="mt10 wrapp">


                <div class="col-lg-12">
                <!--
                <tr>
                            <td><input type="text" class="form100" id="nombre" placeholder="  Buscar Cliente"></input></td>
                            <td><input type="text" class="form100" id="categoria" placeholder="  Buscar Cliente"></input></td>   
                            <td><input type="text" class="form100"  id="estado" placeholder="  Buscar Cliente"></input></td>
                            <td></td>
                            <td></td>
                        </tr>-->
                    <table class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Nombre</th>
                                 
                                <th>Categoria</th>
                                <th>Estado</th>
                                 
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        
                            @foreach($geofences  as $geofence)
                            <tr>
                                <td>
                                    @if ($geofence->type == 'poly')
                                       <span class="glyphicon glyphicon-play" aria-hidden="true"></span>
                                        @else
                                        <span class="glyphicon glyphicon-adjust" aria-hidden="true"></span>
                                    @endif
                                {{ $geofence->name }}</td>
                                


                                @if(isset($geofence->gcat->name))
                                <td>{{ $geofence->gcat->name  }}</td>
                                @endif
                                <td>{{ $geofence->state->name  }}</td>
                                 
                                <td>

                                    @if ($geofence->type == 'poly')
                                        <input class="see_geofence" type="checkbox" ide="{{ $geofence->id }}" color="{{ $geofence->color }}" polydata="{{ $geofence->poly_data }}"  name="{{ $geofence->name }}"   tipo="{{ $geofence->type }}" value="">
                                        @else
                                        <input class="see_geofence" type="checkbox" ide="{{ $geofence->id }}" color="{{ $geofence->color }}" radius="{{ $geofence->radius }}" lat="{{ $geofence->lat }}" name="{{ $geofence->name }}" lng="{{ $geofence->lng }}"  tipo="{{ $geofence->type }}" value="">
                                    @endif
                                    ver

                                    
                                </td>
                                <td><a href="/geofence/delete/{{ $geofence->id }}" class="btn btn-danger btn-xs">Eliminar</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="mt10 wrapp">
                <div class="col-md-12"  >
                    <div class="drawingManager">
                        <div>
        <button id="delete-button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
      </div>

                    </div>
                    <input id="pac-input" class="controls" type="text" placeholder="Buscar direcciones">
                    <div id="map" style="height:600px;"></div>
                </div>
                <div class="clear"></div>
            </div>

        </div>
    </div>
</div>
@stop
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw&libraries=drawing,places" type="text/javascript"></script>
 
<script src="js/drawing.js"></script>
<script type="text/javascript">
    $("#nombre").on("keyup", function() {
var value = $(this).val();
console.log(value)
$("table tr").each(function(index) {
    if (index !== 0) {

        $row = $(this);

        var id = $row.find("td:first").text();
        console.log(id)

        if (id.indexOf(value) !== 0) {
            $row.hide();
        }
        else {
            $row.show();
        }
    }
});
});

$("#categoria").on("keyup", function() {
var value = $(this).val();

$("table tr").each(function(index) {
    if (index !== 0) {

        $row = $(this);

        var id = $row.find("td:second").text();

        if (id.indexOf(value) !== 0) {
            $row.hide();
        }
        else {
            $row.show();
        }
    }
});
});

$("#search").on("keyup", function() {
var value = $(this).val();

$("table tr").each(function(index) {
    if (index !== 0) {

        $row = $(this);

        var id = $row.find("td:first").text();

        if (id.indexOf(value) !== 0) {
            $row.hide();
        }
        else {
            $row.show();
        }
    }
});
});


</script>
@if (session()->has('flash_notification.message'))
<script type="text/javascript">
    swal("{!! session('flash_notification.message') !!}", "", "success")
</script>
@endif


<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@stop
