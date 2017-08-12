@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Alta de viaje</h1>
            @include('partials/errors')
            @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <form class="" action="/travels/create" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="">Nombre del viaje</label>
                    <input type="text" name="name" value="">
                </div>
                <div class="form-group">
                    <select name="route_id" class=" form-control">
                        <option value=""> Selecciona una ruta</option>
                        @foreach($routes  as $route)
                        <option value="{{ $route->id }}">{{ $route->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Chofer</label>
                    <select name="driver_id" class=" form-control">
                        <option value=""> Selecciona un chofer</option>
                        @foreach($drivers  as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Unidad</label>
                    <select name="device_id" class=" form-control">
                        <option value=""> Selecciona una unidad</option>
                        @foreach($devices  as $device)
                        @if($device->status ==0)
                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Fecha Salida</label>
                    <input name="init" class="datepicker init form-control" value="{{ old('init') }}"data-date-format="yyyy-mm-dd hh:mm:ss">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control hour_init" name="hour_init" value="">
                    <!--<select class="form-control hour_init" name="hour_init">
                    <option value="01:00:00">01:00</option>
                    <option value="02:00:00">02:00</option>
                    <option value="03:00">03:00</option>
                    <option value="04:00">04:00</option>
                    <option value="05:00">05:00</option>
                    <option value="06:00">06:00</option>
                    <option value="07:00">07:00</option>
                    <option value="08:00">08:00</option>
                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    <option value="17:00">17:00</option>
                    <option value="18:00">18:00</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                    <option value="21:00">21:00</option>
                    <option value="22:00">22:00</option>
                    <option value="23:00">23:00</option>
                </select> -->
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="control-label">Fecha Llegada</label>
                <input name="end" class="datepicker end form-control" data-date-format="yyyy-mm-dd">
            </div>
            <div class="form-group">
                <input type="text" class="form-control hour_end" name="hour_end" value="">
                <!--<select class="form-control hour_end" name="hour_end">
                <option value="01:00">01:00</option>
                <option value="02:00">02:00</option>
                <option value="03:00">03:00</option>
                <option value="04:00">04:00</option>
                <option value="05:00">05:00</option>
                <option value="06:00">06:00</option>
                <option value="07:00">07:00</option>
                <option value="08:00">08:00</option>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
                <option value="17:00">17:00</option>
                <option value="18:00">18:00</option>
                <option value="19:00">19:00</option>
                <option value="20:00">20:00</option>
                <option value="21:00">21:00</option>
                <option value="22:00">22:00</option>
                <option value="23:00" selected>23:00</option> -->
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Cliente</label>
            <select name="subclient_id" class=" form-control">
                <option value=""> Selecciona un cliente</option>
                @foreach($subclients  as $subclient)
                <option value="{{ $subclient->id }}">{{ $subclient->name }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">

        <input class="btn btn-primary" type="submit" name="" value="Guardar">
    </div>
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
$('.datepicker').datetimepicker({
    todayHighlight: true,
    autoclose:true
});
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
