@extends('layouts.master')
@section('content')
<div class="container-fluid">
<div class="row mt30">

    <div class="col-md-6">
        <h1>{{ $client->name }}</h1>
        <table class="table table-striped table-hover table-condensed">
            <thead  class="thead-inverse">
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Email</th>
                    <th>Geocerca</th>
                    <th>Teléfono</th>
                    <th>Teléfono 2</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($client->location as $location)
            <tr>
                <td>{{ $location->name }}</td>
                <td>{{ $location->direction }}</td>
                <td>{{ $location->email }}</td>
                @if(isset($location->geofences->name ))
                <td>{{ $location->geofences->name }}</td>
                @else
                <td>Geocerca eliminada</td>
                @endif
                <td>{{ $location->phone }}</td>
                <td>{{ $location->phone_2 }}</td>
                <td><a class="btn btn-primary btn-xs" href="/location/{{ $location->id }}">Editar</a></td>
                <td><a class="btn btn-primary btn-xs" href="/location/delete/{{ $location->id }}">Eliminar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="col-md-6">
        <div id="client_map">

        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script src="/js/client.js"></script>

<script  >

var map = new google.maps.Map(document.getElementById('client_map'), {
    zoom: 10,
    center: new google.maps.LatLng(25.680389, -100.318796),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    disableDefaultUI: true,
    zoomControl: true
});
@foreach($client->location as $location)
@if(isset($location->geofences->name ))
@if($location->geofences->type=='circle')
    console.log("circle")
    draw_circle = new google.maps.Circle({
        center: {lat: {{ $location->geofences->lat }}, lng: {{ $location->geofences->lng }} },
        radius: {{ $location->geofences->radius }},
        strokeColor: "#cccccc",
        strokeOpacity: 0.8,
        strokeWeight: 0,
        fillColor: '#1E90FF',
        fillOpacity: 0.45,
        map: map
    })

    var infowindow = new google.maps.InfoWindow({
        content: "{{ $location->geofences->name }}"
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng({{ $location->geofences->lat }}, {{ $location->geofences->lng }}),
        map:  map,
        icon: ' '
    });
    infowindow.open(map, marker);
@else

     //var poly_data = JSON.parse({!! $location->geofences->poly_data!!});


    var draw_circle = new google.maps.Polygon({
        paths: {!! $location->geofences->poly_data!!},
        fillColor: '#1E90FF',
        strokeWeight: 0,
        fillOpacity: 0.35,
        map: map
    });

    var data = {!! $location->geofences->poly_data !!}
    console.log()

    var infowindow = new google.maps.InfoWindow({
        content: "{{ $location->geofences->name }}"
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(data[0].lat, data[0].lng),
        map:  map,
        icon: ' '
    });
    infowindow.open(map, marker);
@endif
@endif
@endforeach
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
