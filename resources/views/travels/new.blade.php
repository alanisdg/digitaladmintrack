@extends('layouts.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Nuevo Requerimiento</h1>
            @include('partials/errors')
            @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif
            <form class="" action="/travels/create_order" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Fecha Salida</label>
                    <input name="init" class="datepicker_auth init form-control" value="{{ old('init') }}" >
                </div>

            <div class="form-group">
                <label for="inputPassword3" class="control-label">Fecha Llegada</label>
                <input name="end" class="datepicker_auth end form-control"  >
            </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Cliente</label>
            <select name="subclient_id" class="cliente form-control chosen-select">
                <option value=""> Selecciona un cliente</option>
                @foreach($subclients  as $subclient)
                <option value="{{ $subclient->id }}">{{ $subclient->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Destino</label>
            <select name="location_id" class="location_ form-control">
                <option value=""> Selecciona una locación</option>

            </select>
        </div>
        <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Chofer</label>
                        <select name="driver_id" class="chosen-select form-control chosen-select">
                            <option value=""> Selecciona un chofer</option>
                            @foreach($drivers  as $driver)

                            <option value="{{ $driver->id }}">{{ $driver->name }} @if($driver->status == 1)  Chofer descargando @endif</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="device_label" for="exampleInputEmail1">Unidad</label>
                        <select name="device_id" class="chosen-select devices form-control">
                            <option value=""> Selecciona una unidad</option>
                            @foreach($devices  as $device)
                            
                            @if($device->status ==0)
                            <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endif
                            @if($device->travel != null)
                            @if($device->travel->tstate_id == 9)
                            <option value="{{ $device->id }}">{{ $device->name }} (Unidad Descargando)</option>
                            @endif
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
                            <option value="{{ $box->id }}">{{ $box->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <div  class="none form-group addbox col-md-6">
                        <label for="exampleInputEmail1">Caja 2</label>
                        <select name="additionalbox_id" class="boxes chosen-select form-control">
                            <option value=""> Selecciona una caja</option>
                            <option value=""> Sin caja </option>
                            @foreach($boxes  as $box)
                            @if($box->status ==0)
                            <option value="{{ $box->id }}">{{ $box->name }} @if($box->new==1) *caja nueva @endif</option>
                            @endif
                            @endforeach
                        </select>
                    </div> 
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Referencia ( usa la barra espazciadora para agregar más referencias)</label>
            <input id="multiple" class="form-control" type="text" name="reference" value="">
        </div>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Folio carta porte</label>
            <input id="multiple" class="form-control" type="text" name="postage" value="">
        </div>
        <div class="form-group col-md-6">
            <label for="exampleInputEmail1">Número de cajas</label>
            <select class="boxs_number" name="boxs_number">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <input type="hidden" name="client_id" value="{{ Auth::user()->client_id }}">

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
$('.datepicker_auth').datetimepicker({
    format: 'YYYY-MM-DD H:m'
});
$(".chosen-select").chosen()

$('.cliente').change(function(){
    console.log('cambio')
    $.ajax({
        url:'locations/get',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id: $('.cliente').val() },
        success: function(r){
            console.log(r)
            $('.location_').empty()
            $('.location_').append('<option >Selecciona una locacion</option>')
            if(r == ''){
                $('.location_').append('<option >Este cliente no cuenta con locaciones</option>')
            }
            $.each(r,function(id,location){
                console.log(location.name)
                $('.location_').append('<option value="'+location.id+'">'+location.name+'</option>')
            })


            


        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
})

$('#multiple').multipleInput();
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
