@extends('layouts.master')
@section('content')
<style type="text/css">
    body{
        background: #202020;
    }
    .table{
        background: white
    }
</style>
<div class="container">
<div class="row mt30">
    <div class="col-md-12" >
            <div class="form-group">
                <h2 style="color: white;
    float: left;
    font-weight: bold;">Choferes</h2>
                <a style="float:right" class="btn btn-success" href="/drivers/add">Agregar Chofer</a>

            </div>
    </div>
    <div class="col-md-12">
        <table class="table table-striped">
        <thead style="color: white;
    background: #434141;
    font-weight: bold;
    font-size: 12px;">
            <tr>
                <td></td>
                <td>Nombre</td>
                <td>Telefono</td>
                <td>Fecha de ingreso</td>
                <td>Fecha de liquidación</td>
                <td>Licencia</td>
                <td>Vigencia</td>
                <td>Foto de licencia</td>
                <td>Vigencia de test aptp</td>
                <td>Foto de test</td>
                <td></td>
            </tr>
            </thead>
        <tbody>
            @foreach($drivers as $driver)
            <tr>
                @if($driver->image != null)
                <td><img style="  height: 18px;" src="{{ $driver->thumb_image }}" alt="..." class="img-circle"></td>
                @else
                <td><img style="  height: 18px;" src="/profile/user.png" alt="..." class="img-circle"></td>
                @endif
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->driver_phone }}</td>
                <td>{{ $driver->driver_first_day }}</td>
                <td>{{ $driver->driver_last_day }}</td>
                <td>{{ $driver->licence }}</td>
                <td>{!! $driver->licence_status($driver->licence_validity) !!}</td>
                
                @if($driver->image_licence != null)
                <td><img style="position: absolute; height: 18px;" src="{{ $driver->image_licence }}" alt="..." class="img-circle"></td>
                @else
                <td><img style="position: absolute; height: 18px;" src="/profile/user.png" alt="..." class="img-circle"></td>
                @endif
                
                <td>{!! $driver->licence_status($driver->driver_test_validity) !!}</td>

                @if($driver->image_test != null)
                <td><img style="position: absolute; height: 18px;" src="{{ $driver->image_test }}" alt="..." class="img-circle"></td>
                @else
                <td><img style="position: absolute; height: 18px;" src="/profile/user.png" alt="..." class="img-circle"></td>
                @endif


                <td><a class="btn btn-primary btn-xs" href="/driver/{{ $driver->id }}">Editar</a></td>
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
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="/js/master.js"></script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
