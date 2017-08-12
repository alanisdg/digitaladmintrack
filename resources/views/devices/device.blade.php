@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-6 text-left ">
        <h3>{{ $device->name }}</h3>
        <b>Editar equipo</b>
        <form action="/device/updateDevice" method="post">
        {!! csrf_field() !!}
            <input type="hidden" class="form-control" value="{{ $device->id }}" name="id">
            <input type="text" class="form-control"  value="{{ $device->name }}" name="name">
            <input type="submit" class="btn btn-primary" value="Editar">
        </form>
        @if ($device->packets()->latest()->first())
        <p>Último reporte:
        {{ $device->lastReport($device->packets()->latest()->first()->updateTime) }}</p>
        @endif

        @if(isset($device->travel))
        {{ $device->travel->name }}
        {{ $device->travel->driver->name }}

        {{ $device->travel->subclient->name }}
        <!-- statu lo interpreta como statu_id si dice status lo interpreta como statuses_id -->
        {{ $device->travel->tstate->name }}
        @endif
    </div>
    <div class="col-md-6 text-left ">
        <div id="map-device"></div>
    </div>

    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/master.js"></script>
<script type="text/javascript">
function resizeMap(){
    b = $('body').height()
    n = $('nav').height()
    f = $('#footer').height()
    map_div = b - n - f;
    $('#map').css('height',map_div+'px')
    console.log('resaisado')
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
map = new google.maps.Map(document.getElementById('map-device'), mapOptions);
marker = new google.maps.Marker({
//marker = new SlidingMarker({
    map: map,
    title: 'I\m sliding marker'
});

@if (isset($device->packets()->latest()->first()->lat))
var myLatlng{{ $device->id }}= new google.maps.LatLng({{ $device->packets()->latest()->first()->lat   }},{{ $device->packets()->latest()->first()->lng   }} );

var marker{{ $device->id }} = new google.maps.Marker({
    position: myLatlng{{ $device->id }},

    icon:'http://usamexgps.com/images/truck3.png',
    rotation:50,
    map:map
});

var label{{ $device->id }} = new MarkerWithLabel({
  position: myLatlng{{ $device->id }},
  map: map,
  icon: " ",
  labelContent: "{{$device->name}}",
  labelAnchor: new google.maps.Point(22, 0),
  labelClass: "labels", // the CSS class for the label
  labelStyle: {opacity: 0.75}
});
map.setZoom(15);
map.panTo(myLatlng{{ $device->id }});
@endif
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
