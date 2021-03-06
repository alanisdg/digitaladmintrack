@extends('admin.layouts.Dasboardlayout')
@section('content') 
<div class="right_col" role="main">
            <h3 class="title">Agregar nueva comision </h3>
            {!! Form::open(['url' => 'dashboard/comisiones/store']) !!}
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

            <select name="user_id" class="form-group">
                  @foreach($contributors as $contributor)
                  <option value="{{ $contributor->id }}"> {{ $contributor->name }}</option>
                  @endforeach
            </select>
             
 
 

            <div class="form-group">
                {{ Form::submit('Guardar' , ['class' => 'btn btn-primary'] )  }}
            </div>


            {!! Form::close() !!}
        </div>
@stop
