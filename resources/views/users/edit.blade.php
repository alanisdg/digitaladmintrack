@extends('layouts.master')
@section('content')
<div class="container">
<div class="row">
    <div class="col-md-8">
        <h1><img src="/images/{{ $user->role->name }}.svg" width="50"> | {{ $user->name }} </h1>
        <form class="" action="/user/editsave" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Correo</label>
                <input type="text" class="form-control" name="mail" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="text" class="form-control" name="password" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Celular</label>
                <input type="text" class="form-control" name="cell" value="{{ $user->cell }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Permiso SMS</label>
                <input type="checkbox" class="" name="cell_up" @if($user->cell_up==1) checked @endif  >
            </div>

            
            <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="text" class="form-control" name="password" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Rol</label>
                <input type="hidden" class="form-control" name="client_id" value="{{ Auth::user()->id }}">
                <select class="form-control" name="role">
                    <option value="1" @if($user->role_id == 1) selected @endif >Developer</option>
                    <option value="6" @if($user->role_id == 6) selected @endif>Master</option>
                    <option value="2" @if($user->role_id == 2) selected @endif>Cliente</option>
                    <option value="3" @if($user->role_id == 3) selected @endif>Monitorista</option>
                    <option value="4" @if($user->role_id == 4) selected @endif>Tráfico</option>
                    <option value="5" @if($user->role_id == 5) selected @endif>Chofer</option>
                </select>
            </div>
            Seleccionar todos <input type="checkbox" id="all"> <br>
            <?php $id = 1 ?>
            @foreach ($devices as $device)
            @if($device->type_id == 1)
            <div class="form-group equipo_"  >
            <label>{{ $device->name }}</label>
            <input type="checkbox" name="devices[]" 
            @foreach ($devices_by_user as $device_by_user)
                @if($device_by_user->id == $device->id)
                    checked
                @endif
            @endforeach
            value="{{ $device->id }}">
            </div>
            @endif
            @endforeach

            @foreach ($boxes as $device)
            @if($device->type_id == 2)
            <div class="form-group equipo_"  >
            <label>{{ $device->name }}</label>
            <input type="checkbox" name="devices[]" 
            @foreach ($devices_by_user as $device_by_user)
                @if($device_by_user->id == $device->id)
                    checked
                @endif
            @endforeach
            value="{{ $device->id }}">
            </div>
            @endif
            @endforeach




            <br>
            Permisos
             
            @if($user->permissions == '')
            <div class="form-group equipo_"  >
            <label>Ver Cajas</label>
            <input type="checkbox" name="permissions[]" value="box">
            </div>

            <div class="form-group equipo_"  >
            <label>Crear Pedidos</label>
            <input type="checkbox" name="permissions[]" value="orders">
             
            </div>
            @else

            <?php 
            $permissions = json_decode($user->permissions,true);
            ?>
            <div class="form-group equipo_"  >
            <label>Ver Cajas</label>
            <input type="checkbox" name="permissions[]" value="box"
            <?php 
            foreach($permissions as $permission){
                if($permission == 'box'){
                    echo "checked";
                }
            }
            ?>
            >
            </div>

            <div class="form-group equipo_"  >
            <label>Crear Pedidos</label>
            <input type="checkbox" name="permissions[]" value="orders"

            <?php 
            foreach($permissions as $permission){
                if($permission == 'orders'){
                    echo "checked";
                }
            }
            ?>
            >
             
            </div>
            @endif
            
             



            <div class="form-group">
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="submit" class="btn btn-primary"   value="Editar">
            </div>
    </div>
    <div class="col-md-4">

    </div>
</div>
</div>
<style type="text/css">
.equipo_{
        width: 15%;
    background: #ececec;
    display: inline-block;
    margin-right: 10px;
    margin: 3px;
    border: 1px solid #c3c3c3;
    padding: 3px 5px;
}
</style>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
 
<script src="/js/travels.js"></script>
<script type="text/javascript">
    $('#all').click(function(){
        if($(this).prop('checked') == true){

    $(':checkbox').prop('checked',true);
        }else{ 
    $(':checkbox').prop('checked',false);
        }
    })
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection