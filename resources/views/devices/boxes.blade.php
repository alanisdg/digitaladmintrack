@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-3 text-left ">
        <a class="btn btn-primary btn-lg" href="/travels/add">Agregar un nuevo viaje</a>
        <ul class="list-unstyled leftlist">
            <li><a href="#">Viajes por mes</a></li>
            <li><a href="#">Viajes en curso</a></li>
        </ul>
    </div>
    <div class="col-md-9 ">
        <table class="table table-striped table-hover table-condensed">
            <thead class="thead-inverse">
                <tr >
                    <th style="border-radius:3px 0px 0px 0px">Nombre</th>

                    <th>Viaje</th>

                    <th style="border-radius:0px 3px 0px 0px"></th>
                </tr>
            </thead>

        <tbody>

            @foreach($boxes as $box)
            <tr>
                <td>{{ $box->name }}</td>
                @if(isset($box->travel->route->name))
                <td>{{ ucfirst($box->travel->route->name) }}</td>
                @else
                <td><span class="badge badge-blue">Disponible</span></td>
                @endif
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
 
<script type="text/javascript">
$('.datepicker').datepicker({
    todayHighlight: true,
    autoclose:true
});

</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
