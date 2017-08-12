@extends('layouts.master')
@section('content')
<style type="text/css">
    body{
        background: #202020;
    }
    .table{
        background: white
    }
</style>
<div class="container">
<div class="row mt30"> 
    <div class="col-md-12" >
            <div class="form-group">
                <h2 style="color: white;
    float: left;
    font-weight: bold;">Usuarios</h2>
                <a style="float:right" class="btn btn-success" href="/users/add">Agregar Usuario</a>

            </div>
    </div> 
    <div class="col-md-12">
        <table class="table table-striped">
            <thead style="color: white;
    background: #434141;
    font-weight: bold;
    font-size: 12px;">
            <tr>
            <td></td>
                <td>Nombre</td>
                <td>Correo</td>
                <td>Rol</td>
                <td>Fecha de creacion</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    @if($user->thumb_image != null)
                                <img style="  height: 18px;" src="{{ $user->thumb_image }}" alt="..." class="img-circle">
                                @else
                                <img style="  height: 18px;" src="/profile/user.png" alt="..." class="img-circle">
                                @endif
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td> <img src="/images/{{ $user->role->name }}.svg" width="18"> {{ $user->role->name }}</td>
                <td>{{ $user->created_at }}</td>
                <td><a class="btn btn-primary btn-xs" href="/user/edit/{{ $user->id }}">Editar</a></td>
                <td><a class="btn btn-primary btn-xs" href="/user/{{ $user->id }}">ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
