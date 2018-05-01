@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
    
            <h3 class="title">Ingresos del mes de {{ date('M') }}</h3>
            <a class="btn btn-primary" href="/dashboard/ingresos/add">Agregar ingreso</a>
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
        </div>
<style type="text/css">
    .lemont{
            border: 1px solid grey;
    margin: 20px;
    padding: 20px;
    float: left;
    }
    .god{

    }
    .bad{
      color:red !important;
    }
    .price{
      font-weight: bold;
    color: #3379b7;
    font-size: 26px;
    }
    .price2{
      font-weight: bold;
    color: #3379b7;
    font-size: 16px;
    }
</style>
@stop