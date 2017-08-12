@extends('admin.layouts.Dasboardlayout')
@section('content') 
<div class="right_col" role="main">
            <h3 class="title">Agregar nuevo usuario </h3>
            {!! Form::open(['url' => 'dashboard/user/store']) !!}
            <div class="form-group">
            {{ Form::label('email', 'E-Mail Address', ['class' => 'form-label']) }}
            {{ Form::text('email', 'example@gmail.com' , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
            {{ Form::text('name'  , null,['class' => 'form-control'] ) }}
            </div>

            <div class="form-group">
            {{ Form::label('password', 'Password', ['class' => 'form-label']) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('role', 'role', ['class' => 'form-label']) }}
            {{ Form::select('role_id', array('0' => 'Selecciona un rol de usuario') + $roles , null, ['class' => 'form-control'] )  }}
            </div>

            <div class="form-group">
            {{ Form::label('client_id', 'Cliente', ['class' => 'form-label']) }}
            {{ Form::select('client_id', array('0' => 'Selecciona un cliente') + $clients , null, ['class' => 'form-control'] )  }}
            </div>

            <div class="form-group">
                {{ Form::submit('Guardar' , ['class' => 'btn btn-primary'] )  }}
            </div>


            {!! Form::close() !!}
        </div>
@stop
