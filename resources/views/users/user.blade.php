@extends('layouts.master')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-8">
        <p>Usuario: {{ $user->name }}</p>
        <p>Correo: {{ $user->email }}</p>
        <p>Ultima sesión: {{ $user->lastlogin }}</p>
        <p>Rol: {{ $user->role->name }}</p>

    </div>
    <div class="col-md-4">
    <h3>Equipos</h3>
    @foreach($devices as $device)
     
    	{{ $device->name }}
     
    @endforeach
    <h3>Cajas</h3>
    @foreach($devices as $device)
    @if($device->type_id == 2)
    	{{ $device->name }}
    @endif
    @endforeach
    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
