@extends('layouts.master')
@section('content')
<div class="container">
<div class="row mt30">
    <div class="col-md-3 text-left ">
        <ul class="list-unstyled leftlist">
            <li>
                <a href="#">Patios</a>
                <ul class="list-unstyled">
                    @foreach($geofences as $geofence)
                        @if($geofence->gcat_id == 2)
                        <li><button type="button" class="btn btn-primary btn-xs get_trucks" geofenceid="{{ $geofence->id }}" name="button">{{ $geofence->name }}</button></li>
                        @endif
                    @endforeach
                    <li><button type="button" class="btn btn-primary btn-xs get_trucks" geofenceid="all" name="button">Todas</button></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="col-md-9 ">
        <table class="table table-striped table-hover table-condensed trucks">
            <thead class="thead-inverse">
                <tr >
                    <th style="border-radius:3px 0px 0px 0px">Nombre</th>

                    <th>Status</th>
                    <th style="border-radius:0px 3px 0px 0px">ver</th>
                </tr>
            </thead>
        <tbody>
            @foreach($trucks as $truck)
            <tr>
                <td>{{ $truck->name }}</td>
                @if(isset($truck->travel->route->name))
                <td>{{ ucfirst($truck->travel->route->name) }}</td>
                @else
                <td><span class="badge badge-blue">Disponible</span></td>
                @endif
                <td><a href="/device/{{ $truck->id }}" class="btn btn-primary btn-xs">ver</a></td>
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
$(".get_trucks").click(function(e){
    console.log($(this).attr('geofenceid'))
    $.ajax({
        url:'devices/get_trucks_by_geofence',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { id:$(this).attr('geofenceid')  },
        success: function(r){
            console.log(r)
            $('.trucks tbody').empty()
            $.each(r['devices'],function(number,device){
                console.log()
                if(device.status == 0){
                    status = '<span class="badge badge-blue">Disponible</span>'
                }else{
                    status = '<span class="badge badge-red">En ruta</span>'
                }
                $('.trucks tbody').append('<tr><td>'+device.name+'</td><td>'+status+'</td></tr>')
            })
        },
        error: function(data){
            var errors = data.responseJSON;
            console.log(errors);
        }
    })
    return false;
});
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
