@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <p>Agregar nuevo usuario </p>
            {!! Form::open(['url' => 'dashboard/client/store']) !!}
            <div class="form-group">
            {{ Form::label('email', 'E-Mail Address', ['class' => 'form-label']) }}
            {{ Form::text('email', 'example@gmail.com' , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
            {{ Form::text('name'  , null,['class' => 'form-control'] ) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Guardar' , ['class' => 'btn btn-primary'] )  }}
            </div>


            {!! Form::close() !!}
        </div> 
@stop
