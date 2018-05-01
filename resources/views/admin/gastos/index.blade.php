@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Gastos del mes de {{ date('M') }}</h3>
            <a class="btn btn-primary" href="/dashboard/gastos/add">Agregar gasto</a>
            <table class="table table-hover table-striped white-table">
                <thead>
                    <td>Concepto</td>
                    <td>Total</td>
                    <td>Fecha</td> 
                    <td>Usuario</td> 
                </thead>
                <tbody>
                    @foreach($gastos as $gasto)
                    <tr>
                        <td>{{ $gasto->concepto }}</td>
                        <td>{{ $gasto->subtotal }}</td>
                        <td>{{ $gasto->date }}</td>
                        <td>{{ $gasto->user->name }}</td>
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