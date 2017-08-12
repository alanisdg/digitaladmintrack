@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-4">
        @if($user->image != null)
        <img src="{{ $user->image }}" alt="..." class="img-circle">
        @else
        <img src="/profile/user.png" alt="..." class="img-circle">
        @endif

        <p>Ultima sesión: {{ $user->lastlogin }}</p>
        <p>Rol: {{ $user->role->name }}</p>
    </div>
    <div class="col-md-8">
        {!! Form::open(['url'=> '/updateprofile','method'=>'POST', 'files' => true]) !!}
        <form class=""   method="post">
            <div class="form-group">
                <label for="">Actualizar foto de perfil</label>
                {!! Form::file('image') !!}
                <p class="errors">{!!$errors->first('image')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Correo</label>
                <input type="text" name="email" value="{{ $user->email }}">
            </div>

            <input type="hidden" name="user_id" value="{{ $user->id }}">
            {!! Form::submit('Submit', array('class'=>'btn btn-primary')) !!}

        </form>

    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
