@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-8">
        <h1>Rutas</h1>
        <form class="" action="/routes/create" method="post">
            <div class="form-group">
                {!! csrf_field() !!}
                <label for="exampleInputEmail1">Origen</label>
                <select name="origin_id" class="select_point form-control">
                    <option value=""> Selecciona un origen</option>
                    @foreach($geofences  as $geofence)
                    @if ($geofence->gcat_id == 1 OR  $geofence->gcat_id == 2 )
                    <option
                    @if ($geofence->type == 'poly' )
                         ide="{{ $geofence->id }}" go="origin" color="{{ $geofence->color }}" polydata="{{ $geofence->poly_data }}"  name="{{ $geofence->name }}"   tipo="{{ $geofence->type }}"
                        @else
                         ide="{{ $geofence->id }}" go="origin"  color="{{ $geofence->color }}" radius="{{ $geofence->radius }}" lat="{{ $geofence->lat }}" name="{{ $geofence->name }}" lng="{{ $geofence->lng }}"  tipo="{{ $geofence->type }}"
                    @endif
                    value="{{ $geofence->id }}">{{ $geofence->name }}</option>
                    @endif
                    @endforeach
                </select>
                <label for="exampleInputEmail1">Destino</label>
                <select name="destination_id" class="select_point form-control">
                    <option value=""> Selecciona un destino</option>
                    @foreach($geofences  as $geofence)
                    @if ($geofence->gcat_id == 1 OR  $geofence->gcat_id == 2 )
                    <option
                    @if ($geofence->type == 'poly')
                         ide="{{ $geofence->id }}" go="dest" color="{{ $geofence->color }}" polydata="{{ $geofence->poly_data }}"  name="{{ $geofence->name }}"   tipo="{{ $geofence->type }}"
                        @else
                         ide="{{ $geofence->id }}" go="dest" color="{{ $geofence->color }}" radius="{{ $geofence->radius }}" lat="{{ $geofence->lat }}" name="{{ $geofence->name }}" lng="{{ $geofence->lng }}"  tipo="{{ $geofence->type }}"
                    @endif
                    value="{{ $geofence->id }}">{{ $geofence->name }}</option>
                    @endif
                    @endforeach
                </select>
                <label for="exampleInputEmail1">Horas Totales de viaje</label>
                <input type="text" name="route-time" value="">

                <label for="exampleInputEmail1">Agregar Referencia</label>

                <div class="input_fields_wrap">
                    <button class="add_field_button">Agregar más referencias</button>
                    <div>
                    <select name="route-ref-id-1" class="route-ref-id-1"></select>

                </div>
                </div>

            </div>
            <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">

            <input type="submit" class="btn btn-primary" name="" value="GUARDAR">
        </form>
    </div>
    <div class="col-md-4">
        <div id="map-travel">

        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script type="text/javascript">
$('.datepicker').datepicker({
    todayHighlight: true,
    autoclose:true
});
selected_ide_origin=''
selected_ide_dest=''
$('.select_point').change(function(){

    var tipo = $('option:selected', this).attr('tipo');
    var radius = $('option:selected', this).attr('radius');
    var lat = $('option:selected', this).attr('lat');
    var lng = $('option:selected', this).attr('lng');
    var ide = $('option:selected', this).attr('ide');
    var tipo = $('option:selected', this).attr('tipo');
    var color = $('option:selected', this).attr('color');
    var polydata = $('option:selected', this).attr('polydata');
    var go = $('option:selected', this).attr('go');
    if(go=='origin'){
        hide_geofence(selected_ide_origin,go)
    }else{
        hide_geofence(selected_ide_dest,go)
    }
    if(tipo=='circle'){
        show_geofence(parseFloat(radius),lat,lng,ide,tipo,0,color,go)
    }else{
        show_geofence(0,0,0,ide,tipo,polydata,color,go)
    }
    if(go=='origin'){
        selected_ide_origin = ide;
    }else{
        selected_ide_dest = ide;
    }

})

geofence_origin = []
geofence_dest =[]
hide_geofence = function(id,go){
    if(go=='origin'){
        $.each(geofence_origin, function( index, value ) {
            if(value.id == id){
                    geofence_origin[index].setMap(null)
                    }
                })
            }else{
                console.log('eliminar destino ' + id + ' ' + go)
                $.each(geofence_dest, function( index, value ) {
                    if(value.id == id){
                        geofence_dest[index].setMap(null)
                    }
                })
    }
}
show_geofence = function(radius,lat_,lng_,id,type,poly_data,color,go){

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
            map: map
        })
        draw_circle.set('id',id)
        if(go=='origin'){
            geofence_origin.push(draw_circle)
        }else{
            console.log('add dest')
            geofence_dest.push(draw_circle);
            console.log('se agrego')
        }
    }else{
        var poly_data = JSON.parse(poly_data);
        var draw_circle = new google.maps.Polygon({
            paths: poly_data,
            fillColor: color,
            strokeWeight: 0,
            fillOpacity: 0.35,
            map: map
          });
          draw_circle.set('id',id)
          if(go=='origin'){
              geofence_origin.push(draw_circle)
          }else{
              console.log('add dest 2')
              geofence_dest.push(draw_circle);
          }
    }
}

ref = 1
function fill_ref_select(){
    $('.route-ref-id-'+ref).append('<option >Selecciona una referencia</option>')
    @foreach($references  as $geofence)
        @if( $geofence->gcat_id==4 OR $geofence->gcat_id==5)
        console.log('alguna')
        $('.route-ref-id-'+ref).append('<option value="{{ $geofence->id }}">{{ $geofence->name }}</option>')
        @endif

    @endforeach
    $(".input_fields_wrap").append('<div class="estimated-hour-'+ref+'">ss<input type="text" name="estimated-hour-'+ref+'"></input></div>'); //add input box

    ref++
}

fill_ref_select()
var max_fields      = 10; //maximum input boxes allowed
   var wrapper         = $(".input_fields_wrap"); //Fields wrapper
   var add_button      = $(".add_field_button"); //Add button ID

   var x = 1; //initlal text box count
   $(add_button).click(function(e){ //on add input button click
       e.preventDefault();
       if(x < max_fields){ //max input box allowed
           x++; //text box increment
console.log('s')
           $(wrapper).append('<select name="route-ref-id-'+ref+'" class="route-ref-id-'+ref+'"></select>');

           fill_ref_select()
       }
   });

   $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
       e.preventDefault(); $(this).parent('div').remove(); x--;
   })
fill_ref_select()

var defaultDeltaExampleEl = document.getElementById('defaultDeltaExample');
var defaultDeltaDatepair = new Datepair(defaultDeltaExampleEl, {
'defaultDateDelta': 1,      // days
'defaultTimeDelta': 7200000 // milliseconds
});
var marker, map;
var myLatlng = new google.maps.LatLng(25.674873, -100.318432);
var mapOptions = {
    zoom: 12,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
}

map = new google.maps.Map(document.getElementById('map-travel'), mapOptions);
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
