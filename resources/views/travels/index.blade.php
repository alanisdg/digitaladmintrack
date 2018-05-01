@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-3 text-left ">
        <h2>Buscador de viajes</h2>
        <ul class="list-unstyled leftlist lest">
            <li><h4>Buscar por fecha</h4>
                
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Fecha Inicial</label>
                    <input name="init" class="datepicker_t init form-control" value="{{ old('init') }}" >
                </div>

                <div class="form-group">
                    <label for="inputPassword3" class="control-label">Fecha Final</label>
                    <input name="end" class="datepicker_t end form-control"  >
                </div>
                <div class="form-group">
                    <input type="submit" value="Buscar" class="btn get_travels_by_date btn-primary btn-xs">
                </div>
            </li>
            <li>
                <hr>
                <h4>Buscar por Referencia</h4>
                <div class="form-group">
                <input type="text" class="reference_val form-control">
                </div>
                <div class="form-group">
                <input type="submit" value="Buscar" class="btn get_travels_by_reference  btn-primary btn-xs">
            </div>
            </li>
            <li><hr>
                <h4>Buscar por chofer</h4>
                <div class="form-group">
                <select class="form-control" id="driver_id"  name="driver_id">
                <option value="">Selecciona un chofer</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Buscar" class="btn get_travels_by_driver btn-primary btn-xs">
            </div>
            </li>

            <li><hr>
                <h4>Buscar por Unidad</h4>
                <div class="form-group">
                <select class="form-control" id="device_id"  name="device_id">
                <option value="">Selecciona una unidad</option>
                @foreach($devices as $device)
                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
                <input type="submit" value="Buscar" class="btn get_travels_by_device btn-primary btn-xs">
            </div>
            </li>
            <li>
                <hr>
                <h4>Buscar por Estado</h4>
                <button by='route' description="'En ruta'" class="btn btn-primary get_travels_by_status btn-xs">En ruta</button>
                <button by='togo' description="Por Salir" class="btn btn-primary get_travels_by_status btn-xs">Por Salir</button>
                <button by='cancel' description="'Cancelados'"  class="btn btn-primary get_travels_by_status btn-xs">Cancelados</button>
                <button style="margin-top: 10px;" by='end' description="'Terminado'"  class="btn btn-primary get_travels_by_status btn-xs">Terminados</button>
            </li>
        </ul>
    </div>
    <div class="col-md-9 ">
        <table class="travel-table table table-striped table-hover table-condensed">
            <thead class="thead-inverse">
                <tr >
                    <th style="border-radius:3px 0px 0px 0px">Codigo</th>
                    <th>Ruta</th>
                    <th>Unidad</th>
                    <th>Chofer</th>
                    <th>Caja 1</th>
                    <th>Caja 2</th>
                    <th>Estado</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>

                    <th style="border-radius:0px 3px 0px 0px"></th>
                </tr>
            </thead>

        <tbody>

        </tr>
            @foreach($travels as $travel)
            <tr id="travel{{ $travel->id }}">
                @if(isset($travel->tcode->code))
                <td>{{ ucfirst($travel->tcode->code) }}</td>
                @endif

                @if(isset($travel->route->name))
                <td>{{ ucfirst($travel->route->name) }}</td>
                @endif

                @if(isset($travel->device->name))
                <td>{{ ucfirst($travel->device->name) }}</td>
                @endif

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

 

              
                <td>
                    <span class="badge travel_{{ $travel->tstate->id }}">{{ $travel->tstate->name }}</span>
                </td>
                <td><a class="btn btn-primary btn-xs" href="/travel/{{ $travel->tcode->id }}">Ver</a></td>
                <td></td>
                <td>
                    @if($travel->tstate_id == 7  or  $travel->tstate_id == 4 )
                    
                    @else
                    <a class="btn btn-primary btn-xs" href="/travel/edit/{{ $travel->id }}">Editar viaje</a>
                    @endif
                </td>
                <td>
                    @if($travel->tstate_id == 7  or  $travel->tstate_id == 4 )
                    
                    @else
                    <a class="btn btn-primary btn-xs cancel_travel"  ide="{{ $travel->id }}">Cancelar</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
<style type="text/css">
    .lest{
            border-radius: 3px;
    border: 1px solid gainsboro;
    background: #d6d6d6;
    padding: 10px;
    }

</style>
<script type="text/javascript">

</script>

@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script type="text/javascript">
$('.datepicker_t').datetimepicker({
    format: 'YYYY-MM-DD H:m'
});
@if (session('travel'))

socket.emit("message"," {{ session('travel') }} " )
@endif



</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
