@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
    <h3 class="title">Balance</h3> 
        <table class="table table-striped">
            @foreach($balances as $balance)
                <tr>
                    <td>{{ $balance->total }}</td>
                    <td>{{ $balance->name }}</td>
                    <td>{{ $balance->detail->subtotal }}</td>
                    <td>{{ $balance->detail->subtotal }}</td>
                    <td>{{ $balance->detail->concepto }}</td>
                </tr>
            @endforeach
        </table>
</div>
<style type="text/css">
    .lemont{
        float: right;
    }
</style>
@stop