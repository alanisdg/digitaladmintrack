@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Equipos</h3>
            <a href="/dashboard/devices/create" class="btn btn-primary">Agregar Equipo</a>
            <select class="client_select">
                    <option> Selecciona un cliente</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>

            <table class="table table-hover table-striped white-table devices_table">
  
            </table>
        </div>
@stop
