@extends('layouts.master')
@section('content')
<div class="mt10 page-content inset">
    <div class="row">
        <div class="col-md-12">
            <div class="wrapp">
                <div class="col-md-3"  >
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#reportes_" aria-controls="viaje" role="tab" data-toggle="tab">Reportes</a></li> 
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="reportes_">
                               <p class="title_grey">Reporte de Geocercas</p>
                    @include('partials/errors_ajax')
                    <form   class="get_geofences" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="control-label">Selecciona una Unidad</label>
                            <select class="form-control chosen-select" id="device_id" name="device_id">
                                @foreach($devices as $device)
                                    <option   value="{{ $device->id }}">{{ $device->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Selecciona una Geocerca</label>
                            <select class="form-control geofence_id chosen-select" name="geofence_id">
                                @foreach($geofences as $geofence)
                                    <option value="{{ $geofence->id }}">{{ $geofence->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="control-label">Fecha Inicial</label>
                                <input name="init" class="datepicker init form-control" value="<?php echo date("Y-m-d")  ?>"data-date-format="yyyy-mm-dd">
                        </div>
                        <div class="form-group">
                            <select class="form-control hour_init" name="">
                                <option value="00:00">00:00</option>
                                <option value="01:00">01:00</option>
                                <option value="02:00">02:00</option>
                                <option value="03:00">03:00</option>
                                <option value="04:00">04:00</option>
                                <option value="04:30">04:30</option>
                                <option value="05:00">05:00</option>
                                <option value="06:00">06:00</option>
                                <option value="07:00">07:00</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="14:40">14:40</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="16:30">16:30</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="control-label">Fecha Final</label>
                                <input name="end" value="<?php echo date("Y-m-d")  ?>" class="datepicker end form-control" data-date-format="yyyy-mm-dd">
                        </div>
                        <div class="form-group">
                            <select class="form-control hour_end" name="">
                                <option value="01:00">01:00</option>
                                <option value="02:00">02:00</option>
                                <option value="03:00">03:00</option>
                                <option value="04:00">04:00</option>
                                <option value="05:00">05:00</option>
                                <option value="06:00">06:00</option>
                                <option value="07:00">07:00</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                                <option value="23:59" selected>23:59</option>
                            </select>
                        </div>
                        <div class="form-group">
                                <button  class="btn btn-primary btn-default">Obtener</button>
                        </div>
                       
                    </form>
                        </div>
                         
                  
                    </div>


                 
                </div>
                <div class="col-md-6"  style="padding: 0 10px;" > 
                    <table class="table table-striped geofence_table">
                        <thead style="background: #151732;
    color: #aeaac7;
    font-size: 12px;">
                            <tr>
                            <td>Geocerca</td>
                            <td>Status</td>
                            <td>Fecha</td>
                            <td>Unidad</td>
                        </tr>
                        </thead>
                        
                        <tbody></tbody>
                            
                        
                    </table>
                </div>
                <div class="col-md-3"  >
                    <div id="map"  ></div>
                </div>
                <div class="clear"></div>
            </div>
           
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery.min.js"></script>
<script src="/js/reports.js"></script>
<script> 
$(".chosen-select").chosen()
$(".get_geofences").submit(function(e){
    loaderON()
    $.ajax({ 
        url:'reports/get_geofences',
        type:'POST',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { device_id: $('#device_id').val(),date_init: $('.init').val(),hour_init: $('.hour_init').val(),date_end: $('.end').val(),hour_end: $('.hour_end').val(),geofence_id: $('.geofence_id').val()},
        success: function(r){
            loaderOFF()
            console.log(r['Geofences'])
            $('.geofence_table tbody').html()
            $('.geofence_table tbody').html(r['Geofences'])
            if(r['Geofences']== ''){
                $('.geofence_table tbody').html('<tr><td colspan="4">Sin registros en el rango de fecha seleccionado</td></tr>')
            }
            poly_data = r['Geofence'][0].poly_data;
            color = r['Geofence'][0].color;
            var poly_data = JSON.parse(poly_data);
            map.setZoom(16);
            map.panTo(new google.maps.LatLng(poly_data[0].lat, poly_data[0].lng));
            console.log(typeof draw_circle)
            if(typeof draw_circle != 'undefined'){
                console.log('defin')
                draw_circle.setMap(null);
            }else{ 
                console.log('no defi')

            }
            var draw_circle = new google.maps.Polygon({
                paths: poly_data,
                fillColor: color,
                strokeWeight: 0,
                fillOpacity: 0.35,
                map: map
              });
            console.log(draw_circle);
        }
    })
    return false;
})
function resizeMap(){
    b = $('body').height();
    mapa = b-65;
    mapa = b/1.5;
    $('#map').height(mapa)
    google.maps.event.trigger(map, "resize");
}

$(window).resize(function() {
    resizeMap()
});
resizeMap()
$('#stop').click(function(){
    console.log('stop')
    if( $(this).is(':checked') == true){
        //mostrar
        $.each(stp,function(a,marker){
        marker.setVisible(true)
        }) 
    }else{
       //esconder
       $.each(stp,function(a,marker){
        marker.setVisible(false)
        }) 
    }
    console.log(stp)

})

$('#stop_by_engine').click(function(){
    console.log('stop')
    if( $(this).is(':checked') == true){
        //mostrar
        $.each(stp_engine,function(a,marker){
        marker.setVisible(true)
        }) 
    }else{
       //esconder
       $.each(stp_engine,function(a,marker){
        marker.setVisible(false)
        }) 
    } 

})
</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@stop
