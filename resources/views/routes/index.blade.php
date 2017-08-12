@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-8">
        <h1>Rutas</h1>
        <a href="/routes/add">Agregar Ruta</a>

    </div>
    <div class="col-md-4">
        <table class="table table-striped">
            <tr>
                <td>Nombre</td>
                <td></td>
            </tr>
        <tbody>
            @foreach($routes as $route)
            <tr>
                <td>{{ $route->name }}</td>
                <td><a class="btn btn-primary" href="/route/{{ $route->id }}">ver</a></td>
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

</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
