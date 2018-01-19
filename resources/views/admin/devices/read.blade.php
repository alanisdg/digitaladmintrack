@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">

    <form class="form-horizontal form-label-left" action="/dashboard/devices/update" method="post">
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombref
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="first-name"value="{{ $device->name }}" name="name" required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Imeis <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="last-name"  name="imei" value="{{ $device->imei }}"  required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Tipo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select class="form-control col-md-7 col-xs-12" name="type_id">
                <option value="1" @if($device->type_id ==1) selected @endif>Tracto</option>
                    <option value="2" @if($device->type_id ==2) selected @endif>Caja</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">N�mero <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="last-name"  name="number" value="{{ $device->number }}"   required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Placa <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="last-name"  name="plate" value="{{ $device->plate }}"   required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cobranza desde: <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="date" id="last-name"  name="charge_from" value="{{ $device->charge_from }}"   required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Detener Cobranza desde: <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="date" id="last-name"  name="stop_from" value="{{ $device->stop_from }}"   required="required" class="form-control col-md-7 col-xs-12">
            </div>
        </div>

                <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Propietario<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <select name="property">
                
            
                @foreach($clients as $client)
                <option value="{{ $client->id }}" @if($client->id == $device->client_id ) selected @endif> {{ $client->name }}</option>
                 
                @endforeach
                </select>
            </div>
        </div> 


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Bloqueo de motor<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="checkbox"  name="engine_block" @if($device->engine_block==1) checked @endif  class="form-control col-md-7 col-xs-12">
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Equipo Virtual <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="checkbox"  name="virtual" @if($device->virtual==1) checked @endif  class="form-control col-md-7 col-xs-12">
            </div>
        </div>


        <input type="hidden" name="id" value="{{ $device->id }}">
        <br>
        @foreach($clients as $client)
        <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ $client->name }}</label>
        <input type="checkbox" class="" name="clients[]" value="{{ $client->id }}"
            <?php
            if($device->type_id == 1){
            $devices = $client->getDevicesAtrribute();
            }else{
                $devices = $client->getBoxsAtrribute();
            } 

            foreach ($devices as $device_selected) {
                if($device_selected == $device->id){ ?>
                    checked
                <?php  }else{echo "no";}
            }
                ?>
                >
            </div>
        @endforeach

                <input type="submit" name="" value="Editar">
            </form>
        </div>
        @stop
