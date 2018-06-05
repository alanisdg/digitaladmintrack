@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
 
           
            <h3 class="title">Balance</h3> 
            <table class="table table-stripped">
                <tr>
                    <td>Ingresos Totales</td>
                    <td></td>
                    <td>Comisiones Totales</td>
                    <td></td>
                    <td>Gastos Totales DAT</td>
                    <td></td>
                    <td>Balance General</td>
                </tr>
                <tr>
                    <td>{{ $ingresos_totales }}</td>
                    <td> - </td>
                    <td>{{ $comisiones_totales }}</td>
                    <td> - </td>
                    <td>{{ $dat_gastos }}</td>
                    <td> = </td>
                    <td>{{ $balance_general }}</td>
                </tr>
            </table>  
           
        </div>
<style type="text/css">
    .lemont{
        float: right;
    }
</style>
@stop