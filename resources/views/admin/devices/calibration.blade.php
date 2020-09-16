@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
    <h2>Calibrando tanque {{ $tank }} del equipo {{ $device->name }}</h2>

    <form class="form-horizontal form-label-left" action="/insert/calibration" method="post">
        {!! csrf_field() !!}
        <?php $campos = 30 ;
        for ($i=1; $i <= 30 ; $i++) { 
            ?>
            <div class="form-group">
            <label class="control-label col-md-1 col-xs-12 " >voltaje <?php echo $i ?>
               
            </label>
            <div class="col-md-3 col-xs-12">
                <input type="text" id="first-name" value="{{ $device->get_volt($i,$device,$tank) }}" name="volt<?php echo $i ?>"  class="form-control col-md-7 col-xs-12">
            </div>

            <label class="control-label col-md-1 col-xs-12 " >Litros <?php echo $i ?>
               
            </label>
            <div class="col-md-3 col-xs-12">
                <input type="text" id="first-name" value="{{ $device->get_lts($i,$device,$tank) }}" name="lts<?php echo $i ?>"  class="form-control col-md-7 col-xs-12">
            </div>
        </div>

            <?php
        }
        ?>
       
      <input type="hidden" name="device_id" value="{{ $device->id }}">
      <input type="hidden" name="tank" value="{{ $tank }}">
                <input type="submit" name="" value="Editar">
            </form>
        </div>
        @stop
