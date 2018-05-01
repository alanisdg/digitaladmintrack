@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">

            <h3 class="title">Comisiones del mes de {{ date('M') }}</h3>
            <a class="btn btn-primary" href="/dashboard/comisiones/add">Agregar comision</a>
            <table class="table table-hover table-striped white-table">
                <thead>
                    <td>Concepto</td>
                    <td>Total</td>
                    <td>Fecha</td> 
                    <td>Usuario</td> 
                </thead>
                <tbody>
                    @foreach($comisiones as $comision)
                    <tr>
                        <td>{{ $comision->motivo }}</td>
                        <td>{{ $comision->subtotal }}</td>
                        <td>{{ $comision->date }}</td>
                        <td>{{ $comision->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
<style type="text/css">
    .lemont{
        float: right;
    }
</style>
@stop