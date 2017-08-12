@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Equipos</h3>
            <a href="/dashboard/devices/create" class="btn btn-primary">Agregar Equipo</a>
            <table class="table table-hover table-striped white-table">
                <thead>
                    <td>Id</td>
                    <td>Nombre</td>
                    <td>Imei</td>
                    <td>Número</td>
                    <td>Placa</td>
                    <td>Cliente(s)</td>
                    <td>Estado</td>
                    <td></td>
                    <td></td>
                    <td>Paquetes</td>
                    <td>sms</td>
                </thead>
                <tbody>
                    @foreach($devices as $device)
                    <tr class="device_{{ $device->id }}">
                        <td>{{ $device->id }}</td>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->imei }}</td>
                        <td>{{ $device->number }}</td>
                        <td>{{ $device->plate }}</td>
                        <td>@foreach($device->clients as $client)
                            {{ $client->name }},
                            @endforeach
                        </td>
                        <td><?php echo $device->statusadmin($device); ?></td>
                        <td>
                            <a href="/dashboard/devices/read/{{ $device->id }}">ver</a>
                        </td>
                        <td>
                            <a  class="delete_device btn btn-danger btn-xs" ide="{{ $device->id }}" >Eliminar</a>

                        </td>
                        <td><a href="/dashboard/packets/{{ $device->id }}">Ver</a></td>
                        <td>
                            <a href="/dashboard/devices/sms/{{ $device->id }}">SMS</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@stop
