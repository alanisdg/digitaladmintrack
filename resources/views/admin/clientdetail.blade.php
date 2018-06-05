@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
 
           
            <h3 class="title">Ingresos del cliente {{ $client->name }} - Precio por unidad  {{ $client->device_price }}</h3> 
            <table class="table table-hover table-striped white-table">
                <thead>
                    <td>Concepto</td>
                    <td>Total</td>
                    <td>Fecha</td> 
                    <td>Usuario</td> 
                </thead>
                <tbody>
                    @foreach($ingresos as $ingreso)
                    <tr>
                        <td>{{ $ingreso->concepto }}</td>
                        <td>{{ $ingreso->subtotal }}</td>
                        <td>{{ $ingreso->date }}</td>
                        <td>{{ $ingreso->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
           
        </div>
<style type="text/css">
    .lemont{
        float: right;
    }
</style>
@stop