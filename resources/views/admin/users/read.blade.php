@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Administrar usuario {{ $user_read->name }} </h3>
            <h6>Ultima sesion {{ $lastSession }}</h6>
            {!! Form::open(['url' => 'dashboard/user/store']) !!}
            <div class="form-group">
            {{ Form::label('email', 'E-Mail Address', ['class' => 'form-label']) }}
            {{ Form::text('email', $user_read->email , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
            {{ Form::text('name'  , $user_read->name,['class' => 'form-control'] ) }}
            </div>

            <div class="form-group">
            {{ Form::label('role', 'role', ['class' => 'form-label']) }}
            {{ Form::select('role_id', array('0' => 'Selecciona un rol de usuario') + $roles , $user->role->id, ['class' => 'form-control'] )  }}
            </div>

            {{ Form::hidden('id', $user_read->id) }}
            <div class="form-group">
                {{ Form::submit('Guardar' , ['class' => 'btn btn-primary'] )  }}
            </div>


            {!! Form::close() !!}
        </div>
@stop
