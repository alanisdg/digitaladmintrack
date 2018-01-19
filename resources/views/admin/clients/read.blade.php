@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
 
        {!! Form::open(['url'=> '/dashboard/client/update','method'=>'POST', 'files' => true, 'class' => 'form-horizontal form-label-left']) !!}
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="first-name"value="{{ $client->name }}" name="name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Dia de corte
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" value="{{ $client->charge_at }}" name="charge_at" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Precio por unidad
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" value="{{ $client->device_price }}" name="device_price" class="form-control col-md-7 col-xs-12">
            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cajas<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="checkbox"  name="boxs" @if($client->boxs==1) checked @endif  class="form-control col-md-7 col-xs-12">
            </div>
        </div> 

        <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Logo</span> </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                {!! Form::file('logo') !!}
                <p class="errors">{!!$errors->first('logo')!!}</p>
                @if(Session::has('error'))
                <p class="errors">{!! Session::get('error') !!}</p>
                @endif
                </div>
            </div>


       
        <input type="hidden"  name="client_id" value="{{ $client->id }}">
                <input type="submit" name="" value="Editar">
            </form>
        </div>
        @stop
