@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Clientes</h3>
            <a class="btn btn-primary" href="/dashboard/clients/add">Agregar Cliente</a>
            <table class="table table-striped white-table">
                <td>Cliente</td>
                <td>Unidades</td>
                <td>Editar</td>
                <td>ID</td>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->devices->count() }}</td>
                        <td><a href="/dashboard/client/{{ $client->id }}" class="btn btn-xs">Editar</a></td>
                        <td>{{ $client->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@stop
