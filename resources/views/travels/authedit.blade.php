@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Editar despacho</h1>
            @include('partials/errors')
            @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <form class="" action="/travel/auth/edit/save" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Fecha Salida</label>
                    <input name="init" class="datepicker init form-control" value="{{ $travel->departure_date }}" >
                </div>

            <div class="form-group">
                <label for="inputPassword3" class="control-label">Fecha Llegada</label>
                <input name="end" class="datepicker end form-control" value="{{ $travel->arrival_date }}">
            </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Cliente</label>
            <select name="subclient_id" class="cliente form-control">
                <option value=""> Selecciona un cliente</option>
                @foreach($subclients  as $subclient)
                @if($subclient->id == $travel->subclient_id)
                <option value="{{ $subclient->id }}" selected>{{ $subclient->name }}</option>
                @else
                <option value="{{ $subclient->id }}">{{ $subclient->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Locacion</label>
            <select name="location_id" class="location form-control">
                <option value=""> Selecciona un cliente</option>
                @foreach($locations  as $location)
                @if($location->id == $travel->location_id)
                <option value="{{ $location->id }}" selected>{{ $location->name }}</option>
                @else
                <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Chofer</label>
                        <select name="driver_id" class="chosen-select form-control">
                            <option value=""> Selecciona un chofer</option>
                            @foreach($drivers  as $driver)
                            <option value="{{ $driver->id }}" 
                            @if(isset($travel->driver->id))
                            @if($travel->driver->id == $driver->id) selected @endif @endif>{{ $driver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="device_label" for="exampleInputEmail1">Unidad</label>
                        <select name="device_id" class="chosen-select devices form-control">
                            <option value=""> Selecciona una unidad</option>
                            @foreach($devices  as $device)
                            @if($device->status ==0)
                            <option value="{{ $device->id }}" 
                            @if(isset($travel->device->id))
                            @if($travel->device->id == $device->id) selected @endif @endif>{{ $device->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="box_label">Caja 1</label>
                        <select name="box_id" class="boxes chosen-select form-control">
                            <option value=""> Selecciona una caja</option>
                            <option value=""> Sin caja </option>
                            @foreach($boxes  as $box)
                            @if($box->status ==0)
                            <option value="{{ $box->id }}" 
                            @if(isset($travel->box->id))
                            @if($travel->box->id == $box->id) selected @endif @endif>{{ $box->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Folio Carta porte</label>
            <input type="text" class="form-control" name="postage" value="{{ $travel->postage }}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Referencias {{ $travel->decode_reference($travel->reference ) }}</label>
            <input id="multiple" class="form-control" type="text" name="reference" value="{{ $travel->reference }}">
            <input type="hidden" name="reference_old" value="{{ $travel->reference }}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Cajas</label>
            <select name="boxs_number" class="boxs_number form-control">
                <option value="1" @if($travel->boxs_number ==1) selected @endif>1</option>
                <option value="2" @if($travel->boxs_number ==2) selected @endif>2</option>
            </select>
        </div>
      


        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <input type="hidden" name="travel_id" value="{{ $travel->id }}">
        <input type="hidden" name="tcode_id" value="{{ $travel->tcode_id }}">
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
    format: 'YYYY-MM-DD HH:mm'
});
$('#multiple').multipleInput();
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
