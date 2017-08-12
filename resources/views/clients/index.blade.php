@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-3">
        <h1>Clientes</h1>
        <a class="btn btn-success" href="/clients/add">Agregar Cliente</a>

    </div>
    <div class="col-md-9">
        <input type="text" id="search" placeholder="  Buscar Cliente"></input>
        <table class="table table-striped table-hover table-condensed">
            <thead  class="thead-inverse">
                <tr>
                    <th>Cliente</th>
                    <th colspan="2">Ubicaciones</th>
                    <th></th>
                </tr>
            </thead>

        <tbody>
            @foreach($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->location->count() }} </td>
                <td>
                    <a class="btn btn-primary btn-xs"  href="/location/add/{{ $client->id }}">Agregar</a>
                    <a class="btn btn-primary btn-xs" href="/client/{{ $client->id }}">Ver</a>
                    <a class="btn btn-primary btn-xs" href="/client/edit/{{ $client->id }}">Editar</a>
                </td>
                <td>
                    <a class="btn btn-danger btn-xs" href="/client/delete/{{ $client->id }}">Eliminar</a>
                </td>
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
$("#search").on("keyup", function() {
var value = $(this).val();
 
var value = value.toLowerCase();

$("table tr").each(function(index) {
    if (index !== 0) {

        $row = $(this);

        var id = $row.find("td:first").text();
        console.log(id + ' el id')
        var id = id.toLowerCase();
        if (id.indexOf(value) !== 0) {
            $row.hide();
        }
        else {
            $row.show();
        }
    }
});
});
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
