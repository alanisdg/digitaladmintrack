@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">

            <h3 class="title">Gastos del mes de {{ $monthName }}</h3> 
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
            <hr>
            <h3 class="title">Ingresos del mes de {{ $monthName }}</h3> 
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
            <h3 class="title">Comisiones del mes de {{ $monthName }}</h3> 
            @foreach($contributors as $contributor)
                    <p>{{ $contributor->name }}</p>
                    @if(!empty($contributor->comissions))
                        @foreach($contributor->comissions as $commision)
                        <p>{{ $commision->motivo }} -> {{ $commision->date }} -> ${{ $commision->subtotal }}</p>
                        @endforeach
                    @endif
                    <hr>
            @endforeach
        </div>
<style type="text/css">
    .lemont{
        float: right;
    }
</style>
@stop