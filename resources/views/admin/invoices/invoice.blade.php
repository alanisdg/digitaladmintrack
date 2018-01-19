@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
<p>{{ $client->name }}</p>
    <table class="table table-condensed table-striped">

<tr class="bg-blue">
<td>Equipo</td>
<td>Estado Cobranza</td>
<td>Fecha</td>
<td>Precio unitario</td>
<td>Días</td>
<td>Total</td>
<tr>
@foreach($devices as $device)
    <tr>
    <td>{{ $device['name'] }}</td>
    <td>{{ $device['month_charge'] }}</td>
    <td> {{ $device['charge_from_date']['date'] }} a {{ $device['stop_from_date']['date'] }}</td>
        <td>
        @if($device['special_price'] == 0)
        $ {{ $client->device_price }}
        @else
        * $ {{  $client->device_price_public($device,$client->device_price)}}
        @endif
     </td>
     <td>{{ $device['days'] }}</td>
     <td>{{ $device['total'] }}</td>
    <tr>
@endforeach
    <tr class="bg-blue">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Sub Total</td>
    <td>$ {{ $invoice->subtotal }}</td>
    </tr>
        <tr class="bg-blue">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>IVA</td>
    <td>$ {{ $invoice->iva }}</td>
    </tr>
    <tr class="bg-blue">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total</td>
    <td>$ {{ $invoice->total }}</td>
    </tr>
        <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><a class="btn btn-danger" href="/dashboard/cancelInvoice/{{$client->id}}">Cancelar</a></td>
    </tr>
</table>
</div>
@stop