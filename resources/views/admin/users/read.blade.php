@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Administrar usuario {{ $user_read->name }} </h3>
            <h6>Ultima sesion {{ $lastSession }}</h6>
            {!! Form::open(['url' => 'dashboard/user/edit']) !!}
            <div class="form-group">
            {{ Form::label('email', 'E-Mail Address', ['class' => 'form-label']) }}
            {{ Form::text('email', $user_read->email , ['class' => 'form-control']) }}
            </div>

            <div class="form-group">
            {{ Form::label('name', 'Name', ['class' => 'form-label']) }}
            {{ Form::text('name'  , $user_read->name,['class' => 'form-control'] ) }}
            </div>

            <div class="form-group">
            {{ Form::label('cell', 'Celular', ['class' => 'form-label']) }}
            {{ Form::text('cell'  , $user_read->cell,['class' => 'form-control'] ) }}
            </div>

            <div class="form-group">
            {{ Form::label('cell_up', 'Permiso de SMS', ['class' => 'form-label']) }}
                            <input type="checkbox"  name="cell_up" @if($user_read->cell_up==1) checked @endif  class="">

            </div>


            <div class="form-group">
            {{ Form::label('role', 'role', ['class' => 'form-label']) }}
            <select class="form-control" name="role_id">
            <?php 
             foreach ($roles as $key => $value) {
            ?> <option value="<?php echo $key;  ?>" <?php if($key == $user_read->role_id){ echo " selected"; } ?>><?php echo $value ?></option>  <?php
        }
            ?>
            </select>
      
            </div>

            <div class="form-group"> 
           {{ Form::hidden('client_id', $user_read->client_id , ['class' => 'form-control']) }}
           {{ Form::hidden('user_id', $user_read->id , ['class' => 'form-control']) }}
            </div>



            {{ Form::hidden('id', $user_read->id) }}
            <div class="form-group">
                {{ Form::submit('Guardar' , ['class' => 'btn btn-primary'] )  }}
            </div>


            {!! Form::close() !!}
        </div>
@stop
