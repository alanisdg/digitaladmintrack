@extends('admin.layouts.Dasboardlayout')
@section('content')
<div class="right_col" role="main">
            <h3 class="title">Equipo: {{ $device->name }}</h3>
            <h3 class="title"><?php echo $device->statusadmin($device); ?></h3>
            <table class="table table-hover table-striped white-table">
                <thead>
                    <td>Update Time</td>
                    
                    <td>Server Time</td>
                    <td>Latitud</td>
                    <td>Longitud</td>
                    <td>Altitud</td>
                    <td>serviceType</td>
                    <td>messageType</td>
                    <td>speed</td>
                    <td>heading</td>
                    <td>sat</td>
                    <td>rssi</td>
                    <td>eventIndex</td>
                    <td>eventCode</td>
                    <td>acumCount</td>
                    <td>power_supply</td>
                    <td>power_bat</td>
                    <td>odometro total</td>
                    <td>odometro_reporte</td>
                    <td>odometro</td>
                    <td>temp1</td>
                    <td>temp2</td>
                    <td>engine</td>
                    <td>engine_block</td>
                    <td>starter_block</td>
                    <td>e_lock</td>
                    <td>power_status</td>
                    <td>low_bat</td>
                    <td>Cadena </td>
                </thead>
                <tbody>
                    @foreach($packets as $packet)
                    <tr>
                        <td>{{ $packet->updateTime }}</td>
                        <td>{{ $packet->serverTime }}</td>
                        <td>{{ $packet->lat }}</td>
                        <td>{{ $packet->lng }}</td>
                        <td>{{ $packet->altitude }}</td>
                        <td>{{ $packet->serviceType }}</td>
                        <td>{{ $packet->messageType }}</td>
                        <td>{{ $packet->speed }}</td>
                        <td>{{ $packet->heading }}</td>
                        <td>{{ $packet->sat }}</td>
                        <td>{{ $packet->rssi }}</td>
                        <td>{{ $packet->eventIndex }}</td>
                        <td>{{ $packet->eventCode }}</td>
                        <td>{{ $packet->acumCount }}</td>
                        <td>{{ $packet->power_supply }}</td>
                        <td>{{ $packet->power_bat }}</td>
                        <td>{{ $packet->odometro_total }}</td>
                        <td>{{ $packet->odometro_reporte }}</td>
                        <td>{{ $packet->odometro }}</td>
                        <td>{{ $packet->temp1 }}</td>
                        <td>{{ $packet->temp2 }}</td>
                        <td>{{ $packet->engine }}</td>
                        <td>{{ $packet->engine_block }}</td>
                        <td>{{ $packet->starter_block }}</td>
                        <td>{{ $packet->e_lock }}</td>
                        <td>{{ $packet->power_status }}</td>
                        <td>{{ $packet->low_bat }}</td>
                        <td  style="width:50px">
                            <div style="overflow:scroll; width:100%">
                                {{ $packet->buffer }}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@stop
