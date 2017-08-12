@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-2 text-left ">
        <a class="btn btn-primary btn-lg" href="/newtravel">Nuevo requerimiento</a>

    </div>
    <div class="col-md-12" style="margin-top: 5px">
        <table class="table table-striped table-hover table-condensed">
            <thead class="thead-inverse">
                <tr >
                    <th style="border-radius:3px 0px 0px 0px">Codigo</th>
                    <th>Referencia</th>
                    <th>folio</th>
                    <th>Fecha de llegada</th>
                    <th>Unidad</th>
                    <th>Chofer</th>
                    <th>Caja</th>
                    <th>Destino</th>

                    <th>Cajas</th>
                    <th>Creado por</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Historial</th>
                    <th style="border-radius:0px 3px 0px 0px"></th>
                </tr>
            </thead>
        <tbody>
            @foreach($orders as $order)
            <tr id="order_{{ $order->tcode_id }}">
                <td>{{ ucfirst($order->tcode->code) }}</td>
                <td>{{ $order->decode_reference($order->reference ) }}</td>
                @if(isset($order->postage))
                <td>{{ $order->postage }}</td>
                @else
                <td> </td>
                @endif
                @if(isset($order->arrival_date))
                <td>{{ $order->arrival_date }}</td>
                @else
                <td> </td>
                @endif
                @if(isset($order->device->name))
                    <td>
                    @if($order->device->status==1)
                    <span class="badge badge-red">{{ $order->device->name }}</span> 
                    @else
                    {{ $order->device->name }}
                    @endif
                    

                    </td>
                @else
                <td> </td>
                @endif
                
                @if(isset($order->driver->name))
                <td>
                @if($order->driver->status==1)
                    <span class="badge badge-red">{{ $order->driver->name }}</span> 
                    @else
                    {{ $order->driver->name }}
                    @endif
                    </td>
 
                @else
                <td> </td>
                @endif
                
                @if(isset($order->box->name))
                <td>
                @if($order->box->status==1)
                    <span class="badge badge-red">{{ $order->box->name }}</span> 
                    @else
                    {{ $order->box->name }}
                    @endif
                    </td>
                @else
                <td> </td>
                @endif


                @if(isset($order->location->name))
                <td>{{ $order->location->name }}</td>
                @else
                <td> </td>
                @endif
                @if(isset($order->boxs_number))
                <td>{{ $order->boxs_number }}</td>
                @else
                <td> </td>
                @endif
                

                @if(isset($order->user->name))
                <td>{{ $order->user->name }}</td>
                @else
                <td> - </td>
                @endif


                <td>
                    <span class="badge travel_{{ $order->tstate->id }}">{{ $order->tstate->name }}</span>
                </td>
                <td><a class="btn btn-primary btn-xs" href="/travel/auth/{{ $order->id }}">Autorizar</a></td>
                <td><a class="btn btn-primary btn-xs" href="/travel/auth/edit/{{ $order->id }}">Editar</a></td>
                <td><a class="btn btn-primary btn-xs" href="/travel/history/{{ $order->tcode_id }}">Historial</a></td>
                <td><a class="btn btn-danger btn-xs delete_order"  ide="{{ $order->tcode_id }}">Eliminar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    </div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script type="text/javascript">
$('.datepicker').datepicker({
    todayHighlight: true,
    autoclose:true
});

</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
