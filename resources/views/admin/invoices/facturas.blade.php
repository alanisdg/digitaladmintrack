@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
    <table class="table table-striped">
        <tr>
        <td>Cliente</td>
        <td>Fecha</td>
        <td>Total</td>
        <td></td>
        </tr>
    @foreach($invoices as $invoice)
        <tr>
        <td>{{ $invoice->client->name }}</td>
        <td>{{ $invoice->year }}/{{ $invoice->month }}</td>
        <td>{{ $invoice->total }}</td>
        <td>
            @if($invoice->payment == 0)
                <span class="btn btn-danger btn-xs">No pagada</span> <a href="/pay/invoice/{{ $invoice->id }}" class="btn btn-primary btn-xs">PAGAR</a>
            @else
                <a class="btn btn-primary btn-xs">Pagada</a>
            @endif
        </td>
        </tr>
     
    @endforeach

    </table>
</div>
@stop