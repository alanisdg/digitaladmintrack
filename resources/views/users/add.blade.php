@extends('layouts.master')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-8">
        <h1>Alta de usuarios</h1>
        @include('partials/errors')
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <form class="" action="/user/create" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" name="name" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Correo</label>
                <input type="text" class="form-control" name="mail" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="text" class="form-control" name="password" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Rol</label>
                <input type="hidden" class="form-control" name="client_id" value="{{ Auth::user()->client_id }}">
                <select class="form-control" name="role">
                    <option value="1">Master</option>
                    <option value="2">Cliente</option>
                    <option value="3">Monitorista</option>
                    <option value="4">Trร�??fico</option>
                    <option value="5">Chofer</option>
                </select>
            </div>
            <?php $id = 1 ?>
            @foreach ($devices as $device)
            <div class="form-group">
            <label>{{ $device->name }}</label>
            <input type="checkbox" name="devices[]" value="{{ $device->id }}">
            </div>
            @endforeach
            <input type="submit" name="" value="crear">
        </form>
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
