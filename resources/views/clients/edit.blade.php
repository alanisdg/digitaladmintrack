@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-md-8">
        <h1>Agregar Cliente</h1>
        <form class="" action="/client/edit" method="post">
            <div class="form-group">
                {!! csrf_field() !!}
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" name="name" value="{{ $client->name }}">
                <label for="exampleInputEmail1">Dirección</label>
                <input type="text" name="direction" value="{{ $client->direction }}">
                <label for="exampleInputEmail1">Telefono</label>
                <input type="text" name="phone" value="{{ $client->phone }}">
                <label for="exampleInputEmail1">Telefono 2</label>
                <input type="text" name="phone_2" value="{{ $client->phone_2 }}">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" name="email" value="{{ $client->email }}">
                <input type="hidden" name="client_id" value="{{ $client->id }}">
                <input type="submit" name="" value="GUARDAR">
        </form>
    </div>
    <div class="col-md-4">
        <div id="map-travel">

        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>

<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
