@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Usuarios</h3>
            <a class="btn btn-primary" href="/dashboard/user/add">Agregar usuario</a>
            <table class="table table-hover table-striped white-table">
                <thead>
                    <td>Id</td>
                    <td>Nombre</td>
                    <td>Imei</td>
                    <td>Rol</td>
                    <td>Celular</td>
                    <td>SMS</td>
                    <td>Cliente</td>
                </thead>
                <tbody>
                    @foreach($users3 as $user_)
                    <tr>
                        <td>{{ $user_->id }}</td>
                        <td>{{ $user_->name }}</td>
                        <td>{{ $user_->email }}</td>
                        <td>{{ $user_->role->name }}</td>
                        <td>{{ $user_->cell }}</td>
                        <td>@if($user_->cell_up == 1) si @endif</td>
                        <td>{{ $user_->client->name }}</td>
                        <td><a href="/dashboard/user/read/{{ $user_->id}}">Administrar</a></td>
                        <td>
                        <a href="/dashboard/user/guest/{{ $user_->id}}">Login</a></td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@stop
