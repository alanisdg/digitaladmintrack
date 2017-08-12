@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-12">
        <p>Ruta: {{ $route->name }}</p>
     <form class="" action="/route/edit" method="post">
         {!! csrf_field() !!}
         <label for="exampleInputEmail1">Origen</label>
         <select name="origin_id" class="select_point form-control">
             <option value=""> Selecciona un origen</option>
             @foreach($geofences  as $geofence)
             @if ($geofence->gcat_id == 1 OR  $geofence->gcat_id == 2 )
             <option
             @if ($geofence->type == 'poly' )
                  ide="{{ $geofence->id }}" @if($route->origin_id == $geofence->id) selected @endif go="origin" color="{{ $geofence->color }}" polydata="{{ $geofence->poly_data }}"  name="{{ $geofence->name }}"   tipo="{{ $geofence->type }}"
                 @else
                  ide="{{ $geofence->id }}" go="origin"  @if($route->origin_id == $geofence->id) selected @endif color="{{ $geofence->color }}" radius="{{ $geofence->radius }}" lat="{{ $geofence->lat }}" name="{{ $geofence->name }}" lng="{{ $geofence->lng }}"  tipo="{{ $geofence->type }}"
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
                  ide="{{ $geofence->id }}" go="dest" @if($route->destination_id == $geofence->id) selected @endif color="{{ $geofence->color }}" polydata="{{ $geofence->poly_data }}"  name="{{ $geofence->name }}"   tipo="{{ $geofence->type }}"
                 @else
                  ide="{{ $geofence->id }}" go="dest" @if($route->destination_id == $geofence->id) selected @endif color="{{ $geofence->color }}" radius="{{ $geofence->radius }}" lat="{{ $geofence->lat }}" name="{{ $geofence->name }}" lng="{{ $geofence->lng }}"  tipo="{{ $geofence->type }}"
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
             <select class="route-ref-name"></select>
             <input type="text" name="route-ref-hour" value="">
         </div>
         </div>
         <input type="hidden" name="route_id" value="{{ $route->id }}">
         <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
         <input type="submit" class="btn btn-primary" name="" value="GUARDAR">
     </form>
    </div>

</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
