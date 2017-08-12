@extends('layouts.master')
@section('content')
<div class="container">


<div class="row">
    <div class="col-md-8">
        <h1>Locacion {{ $location->name }}</h1>
            <p>Nombre: {{ $location->name }}</p>
            <form class="" action="/tolocation/save" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="">Nombre</label>
                    <input type="text" name="name" value="{{ $location->name }}">
                </div>
                <div class="form-group">
                    <label for="">Nombre</label>
                    <input type="text" name="direction" value="{{ $location->direction }}">
                </div>
                <div class="form-group">
                    <label for="">Teléfono</label>
                    <input type="text" name="phone" value="{{ $location->phone }}">
                </div>
                <div class="form-group">
                    <label for="">Teléfono 2</label>
                    <input type="text" name="phone_2" value="{{ $location->phone_2 }}">
                </div>

        <input type="hidden" name="location_id" value="{{ $location->id }}">

        <input class="btn btn-primary" type="submit" name="" value="Editar">
    </div>
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
