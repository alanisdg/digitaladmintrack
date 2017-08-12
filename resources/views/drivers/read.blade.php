@extends('layouts.master')
@section('content')

<div class="container">
<div class="row mt30">
    <div class="col-md-4">
        @if($driver->image != null)
        <img src="{{ $driver->image }}" alt="..." class="img-circle">
        @else
        <img src="/profile/user.png" alt="..." class="img-circle">
        @endif


    </div>
    <div class="col-md-8">
        {!! Form::open(['url'=> '/driver/update','method'=>'POST', 'files' => true]) !!}
        <form class=""   method="post">
            <div class="form-group">
                <label for="">Actualizar foto de perfil</label>
                {!! Form::file('image') !!}
                <p class="errors">{!!$errors->first('image')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" name="name" value="{{ $driver->name }}">
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Telefono</label>
                <input type="text" class="form-control" name="driver_phone" value="{{ $driver->driver_phone }}">
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Fecha de ingreso</label>
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="driver_first_day" value="{{ $driver->driver_first_day }}" >
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Fecha de liquidacion</label>
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="driver_last_day" value="{{ $driver->driver_last_day }}">
            </div>




            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Licencia</label>
                <input type="text" class="form-control" name="licence" value="{{ $driver->licence }}">
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Vigencia Licencia</label>
                <input type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" name="licence_validity" value="{{ $driver->licence_validity }}">
            </div>

            <div class="form-group col-md-6">
                <label for="">Agregar foto de licencia</label>
                <input name="image_licence" type="file" class="form-control">
                <p class="errors">{!!$errors->first('image_licence')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Vigencia de apto para conducir</label>
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" value="{{ $driver->driver_test_validity }}"name="driver_test_validity" >
            </div>


            <div class="form-group col-md-6">
                <label for="">Agregar foto de examane apto para conducir</label>
                <input name="image_test" type="file" class="form-control">
                <p class="errors">{!!$errors->first('image_test')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>



            <input type="hidden" name="driver_id" value="{{ $driver->id }}">
            {!! Form::submit('Actualizar', array('class'=>'btn btn-primary')) !!}

        </form>

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
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
