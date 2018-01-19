@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Clientes</h3>
            <a class="btn btn-primary" href="/dashboard/clients/add">Agregar Cliente</a>
            <table class="table table-striped white-table">
                <td>Cliente</td>
                <td>Unidades</td>
                <td>Editar</td>
                <td>Día de corte</td>
                <td>Precio por unidad</td>
                <td></td>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->devices->count() }}</td>
                        <td><a href="/dashboard/client/{{ $client->id }}" class="btn btn-xs">Editar</a></td>
                        <td>{{ $client->charge_at }}</td>
                        <td>{{ $client->device_price }}</td>
                        <td><a href="/dashboard/invoices/{{ $client->id }}">Ver Facturas</a></td>
                        <td><a href="/dashboard/invoice/{{ $client->id }}">Ver factura</a></td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
@stop
