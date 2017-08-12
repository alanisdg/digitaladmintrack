@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-12">
        <table class="table table-striped table-hover table-condensed">
            <thead class="thead-inverse">
                <tr >
                    <th style="border-radius:3px 0px 0px 0px">Codigo</th>
                    <th>Ruta</th>
                    <th>Unidad</th>
                    <th>Cliente</th>
                    <th>Locación</th>
                    <th>Chofer</th>
                    <th>Caja 1</th>
                    <th>Caja 2</th>
                    <th>Tiempo</th>
                    <th>Creado por</th>
                    <th>Fecha</th>
                    <th></th>
                    <th></th>

                    <th style="border-radius:0px 3px 0px 0px"></th>
                </tr>
            </thead>

        <tbody>

            @foreach($travels as $travel)
            <tr>
                @if(isset($travel->tcode->code))
                <td>{{ ucfirst($travel->tcode->code) }}</td>
                @endif


                @if(isset($travel->route->name))
                <td>{{ ucfirst($travel->route->name) }}</td>
                @else
                <td>Sin ruta asignada</td>
                @endif

                @if(isset($travel->device->name))
                <td>{{ ucfirst($travel->device->name) }}</td>
                @else
                <td>Sin unidad asignada</td>
                @endif

                <td>{{ $travel->subclient->name }}</td>
                <td>{{ $travel->location->name }}</td>
                @if(isset($travel->driver->name))
                <td>{{ ucfirst($travel->driver->name) }}</td>
                @endif

                @if(isset($travel->box->name))
                <td>{{ $travel->box->name}}</td>
                @else
                <td>Sin caja</td>
                @endif

                @if(isset($travel->additionalbox->name))
                <td>{{ $travel->additionalbox->name}}</td>
                @else
                <td>Sin caja</td>
                @endif


                @if($travel->tstate_id == 2)
                <td>{{ $travel->device->leftTime($travel->arrival_date) }}</td>
                @endif
                @if($travel->tstate_id == 1)
                <td>{{ $travel->device->leftTime($travel->departure_date) }}</td>
                @endif
                @if($travel->tstate_id == 4)
                <td> </td>
                @endif
                @if(isset($travel->tstate->name))
              
                
                <td>
                    <span class="badge travel_{{ $travel->tstate->id }}">{{ $travel->tstate->name }}</span>
                </td>
                @endif
                <td>{{ $travel->user->name }}</td>
                <td>{{ $travel->created_at }}</td>
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
