@extends('admin.layouts.Dasboardlayout')
@section('content') 
<div class="right_col" role="main">
<p>Cliente: {{ $client->name }} </p>
<p>Fecha de facturación: {{ $to_date }} </p>
<p>Fecha: {{ $from_date }} a {{ $to_date }}</p>
<table class="table table-condensed table-striped">
<tr class="bg-blue">
<td>Equipo</td>
<td>Estado Cobranza</td>
<td>Fecha</td>
<td>Precio unitario</td>
<td>Días</td>
<td>Total</td>
<tr>
@foreach($total_devices as $device)
    <tr @if($client->device_price($device,$client->device_price) == 'cancelado') class="bg-red" @endif>
    <td>{{ $device->name }}</td>
    <td>{{ $device->month_charge }}</td>
    <td>{{ $device['charge_from_date'] }} a {{ $device['stop_from_date'] }}</td>
    <td>{{  $client->device_price($device,$client->device_price)}}</td>
    <td>{{ $device->days }}</td>
    <td>{{ $device->total }}</td>
    <tr>
@endforeach
    <tr class="bg-blue">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Sub Total</td>
    <td>$ {{ $total_count }}</td>
    </tr>
        <tr class="bg-blue">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>IVA</td>
    <td>$ {{ $iva }}</td>
    </tr>
    <tr class="bg-blue">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total</td>
    <td>$ {{ $total }}</td>
    <tr>
        <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><a class="btn btn-primary" href="/dashboard/publicInvoice/{{$client->id}}">Facturar</a></td>
    <tr>
</table>
        </div>
 <style type="text/css">
     .invoice{
        border:1px solid grey;
        font-family: 'Arial'
     }

 </style>
 @stop