@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
    <h1>Equipo {{ $device->name }}</h1>
                <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Conexion !R3,44,69
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,44,69" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div>

        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">!R3,49,129
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,49,129" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 


         

        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Conexion !R3,49,129
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,49,129" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 


        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Desconexion !R3,44,68
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,44,68" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 
        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Codigo !R3,44,31
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,44,31" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 

        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Codigo !R3,262,0,20
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,262,0,20" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 

        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Codigo !R3,262,0,5
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,262,0,5" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 

        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Codigo !R3,262,1,5
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,262,1,5" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 

        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Codigo !R3,262,0,300
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,262,0,300" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 


        <div class="form-group">
            <form class="form-horizontal form-label-left" action="/nexmo/send" method="post">
        {!! csrf_field() !!}
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">RESETEO !R3,70,0
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="hidden"  value="{{ $device->id }}" name="device_id" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="{{ $device->number }}" name="number" required="required" class="form-control col-md-7 col-xs-12">
                <input type="hidden" id="first-name"value="!R3,70,0" name="code" required="required" class="form-control col-md-7 col-xs-12">
                <input type="submit" value="enviar" class="btn btn-primary btn-xs">
            </div>
                </form>
        </div> 


        
        </div>
        @stop