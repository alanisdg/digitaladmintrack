@extends('admin.layouts.Dasboardlayout')
@section('content') 
<div class="right_col" role="main">
            <h3 class="title">Agregar nuevo ingreso </h3>
            {!! Form::open(['url' => 'dashboard/ingresos/store', 'files' => true]) !!}

            <div class="form-group">
                <label for="">Subir Factura</label>
                {!! Form::file('image') !!}
                <p class="errors">{!!$errors->first('image')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>


            <div class="form-group">
            {{ Form::label('email', 'Concepto', ['class' => 'form-label']) }}
            {{ Form::text('concepto', '' , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('subtotal', 'subtotal', ['class' => 'form-label']) }}
            {{ Form::text('subtotal', '' , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('fecha', 'date', ['class' => 'form-label']) }}
            {{ Form::date('date', '' , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            <select class="form-group" name="client_id">
                  @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                  @endforeach
            </select>
            </div>

            <input type="hidden" name="user_id" value="{{ $user->id }}">
 

 

            <div class="form-group">
                {{ Form::submit('Guardar' , ['class' => 'btn btn-primary'] )  }}
            </div>


            {!! Form::close() !!}
        </div>
@stop
