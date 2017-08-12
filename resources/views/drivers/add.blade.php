@extends('layouts.master')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-12">
        <h1>Alta de chofer</h1>
        @include('partials/errors')
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif

        {!! Form::open(['url'=> '/drivers/create','method'=>'POST', 'files' => true]) !!}
        <form class=""   method="post">
            

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" name="name">
            </div>

            <div class="form-group col-md-6">
                <label for="">Agregar foto de perfil</label>
                <input name="image" type="file" class="form-control">
                <p class="errors">{!!$errors->first('image')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Fecha de ingreso</label>
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="driver_first_day" >
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Fecha de liquidacion</label>
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="driver_last_day" >
            </div>



            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Celular</label>
                <input type="text" class="form-control" name="driver_phone" >
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Numero Licencia</label>
                <input type="text" class="form-control" name="licence" >
            </div>

            <div class="form-group col-md-6">
                <label for="exampleInputEmail1">Vigencia de Licencia</label>
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="licence_validity" >
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
                <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" name="driver_test_validity" >
            </div>

            <div class="form-group col-md-6">
                <label for="">Agregar foto de examane apto para conducir</label>
                <input name="image_test" type="file" class="form-control">
                <p class="errors">{!!$errors->first('image_test')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>

            <input type="hidden" id="client_id" name="client_id" value="{{ Auth::user()->client_id }}">
            {!! Form::submit('Agregar', array('class'=>'btn btn-primary')) !!}
    </div>
    <div class="col-md-4">

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
