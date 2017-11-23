    @extends('layouts.master')
    @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Autorizar viajes</h1>
                @include('partials/errors')
                @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                <form class="" action="/travel/auth/save" method="post">
                {!! csrf_field() !!}
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Cliente Origen</label>
                        <select class="origin_client form-control chosen-select">
                            <option value=""> Selecciona un cliente</option>
                            @foreach($subclients  as $subclient)
                             
                            <option value="{{ $subclient->id }}">{{ $subclient->name }}</option>
                        
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Locación Origen</label>
                        <select name="origin_id" class="origin_id form-control col-md-6">
                            <option value=""> Selecciona un origen</option>
                      
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Cliente Destino</label>
                        <select name="subclient_id" class="cliente form-control chosen-select">
                            <option value=""> Selecciona un cliente</option>
                            @foreach($subclients  as $subclient)
                            @if($subclient->id == $travel->subclient_id)
                            <option value="{{ $subclient->id }}" selected>{{ $subclient->name }}</option>
                            @else
                            <option value="{{ $subclient->id }}">{{ $subclient->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Locación Destino</label>
                        <select name="location_id" class="location form-control ">
                            <option value=""> Selecciona un cliente</option>
                            @foreach($locations  as $location)
                            @if($location->id == $travel->location_id)
                            <option value="{{ $location->id }}" rel="{{ $location->geofences_id }}" selected>{{ $location->name }}</option>
                            @else
                            <option value="{{ $location->id }}" rel="{{ $location->geofences_id }}">{{ $location->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-12 posibleRoute hideForm">
                        <label for="exampleInputEmail1">Selecciona una ruta disponibles</label>
                        <span class="btn btn-primary btn-xs createNewRoute">Crear nueva Ruta</span>
                        <select name="route_id" class="col-md-12 posible form-control">
                            
                        </select>
                    </div>

                    <!--
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Horas Totales de viaje</label>
                        <input type="text" name="route-time" value="">
                    </div>-->


                    <div class="form-group col-md-12  makeRoute hideForm">
                        <label for="exampleInputEmail1">Crear Referencias</label>
                        <div class="input_fields_wrap">
                            <div>
                                <label class="control-label">Estado</label>
                                <select class="form-control state " toform="1" name="state_id">
                                    <option value="">Selecciona un Estado</option>
                                    <option value="1">Aguascalientes</option>
                                    <option value="2">Baja California</option>
                                    <option value="3">Baja California Sur</option>
                                    <option value="4">Campeche </option>
                                    <option value="5">Coahuila de Zaragoza </option>
                                    <option value="6">Colima </option>
                                    <option value="7">Chiapas </option>
                                    <option value="8">Chihuahua </option>
                                    <option value="9">Ciudad de México </option>
                                    <option value="10">Durango </option>
                                    <option value="11">Guanajuato </option>
                                    <option value="12">Guerrero </option>
                                    <option value="13">Hidalgo </option>
                                    <option value="14">Jalisco </option>
                                    <option value="15">Estado de México </option>
                                    <option value="16">Michoacán </option>
                                    <option value="17">Morelos </option>
                                    <option value="18">Nayarit </option>
                                    <option value="19">Nuevo León </option>
                                    <option value="20">Oaxaca </option>
                                    <option value="21">Puebla </option>
                                    <option value="22">Querétaro </option>
                                    <option value="23">Quintana Roo </option>
                                    <option value="24">San Luis Potosí </option>
                                    <option value="25">Sinaloa </option>
                                    <option value="26">Sonora </option>
                                    <option value="27">Tabasco </option>
                                    <option value="28">Tamaulipas </option>
                                    <option value="29">Tlaxcala </option>
                                    <option value="30">Veracruz </option>
                                    <option value="31">Yucatán </option>
                                    <option value="32">Zacatecas </option>
                                    <option value="33">Texas </option>
                                    <option value="34">New Mexico </option>
                                    <option value="35">Arizona </option>
                                    <option value="36">California </option>
                                    <option value="37">Louisiana </option>
                                    <option value="38">Mississippi </option>
                                </select>
                                <select name="route-ref-id-1" class="form-control b5 route-ref-id-1"></select>
                            </div>
                        </div>
                        <span class="add_field_button btn btn-primary btn-xs">Agregar más referencias</span>
                        <span class="remove_field_button btn btn-primary btn-xs">Quitar referencias</span>
                        <span class="hideForm posibleRouteButton btn btn-primary btn-xs">Seleccionar ruta disponible</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1">Chofer</label>
                        <select name="driver_id" class="chosen-select form-control">
                            <option value=""> Selecciona un chofer</option>
                            @foreach($drivers  as $driver)
                            <option value="{{ $driver->id }}" 
                            @if(isset($travel->driver->id))
                            @if($travel->driver->id == $driver->id) selected @endif @endif>{{ $driver->name }} @if($driver->status == 1)  Chofer descargando @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="device_label" for="exampleInputEmail1">Unidad</label>
                        <select name="device_id" class="chosen-select devices form-control">
                            <option value=""> Selecciona una unidad</option>
                            @foreach($devices  as $device)
                                @if($device->status ==0)
                                    <option value="{{ $device->id }}" 
                                    @if(isset($travel->device->id))
                                    @if($travel->device->id == $device->id) selected @endif @endif>{{ $device->name }}</option>
                                @endif

                                @if($device->travel != null)
                                    @if($device->travel->tstate_id == 9)
                                    <option value="{{ $device->id }}" 
                                    @if(isset($travel->device->id))
                                    @if($travel->device->id == $device->id) selected @endif @endif>{{ $device->name }} (Unidad Descargando)</option>
                                    @endif
                                @endif


                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class="control-label">Fecha Salida</label>
                        <input name="init" class="datepicker_auth init form-control" value="{{ $travel->departure_date }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword3" class="control-label">Fecha Llegada</label>
                        <input name="end" class="datepicker_auth end form-control" value="{{ $travel->arrival_date }}" >
                    </div>


                    <div class="form-group col-md-6">
                        <label   for="exampleInputEmail1">Cajas</label>
                        <select name="boxs_number" class="boxs_number chosen-select form-control">
                            <option value="1" @if($travel->boxs_number ==1) selected @endif>1</option>
                            <option value="2" @if($travel->boxs_number ==2) selected @endif>2</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="box_label">Caja 1</label>
                        <select name="box_id" class="boxes chosen-select form-control">
                            <option value=""> Selecciona una caja</option>
                            <option value=""> Sin caja </option>
                            @foreach($boxes  as $box)
                            @if($box->status ==0)
                            <option value="{{ $box->id }}" 
                            @if(isset($travel->box->id))
                            @if($travel->box->id == $box->id) selected @endif @endif>{{ $box->name }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @if($travel->boxs_number !=1)
                    <div class="form-group addbox col-md-6">
                        <label for="exampleInputEmail1">Caja 2</label>
                        <select name="additionalbox_id" class="boxes chosen-select form-control">
                            <option value=""> Selecciona una caja</option>
                            <option value=""> Sin caja </option>
                            @foreach($boxes  as $box)
                            @if($box->status ==0)
                            <option value="{{ $box->id }}">{{ $box->name }} @if($box->new==1) *caja nueva @endif</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <input type="hidden" name="client_id" value="{{ Auth::user()->client_id }}">
                    <input type="hidden" name="travel_id" value="{{ $travel->id }}">
                    <input type="hidden" name="tcode_id" value="{{ $travel->tcode_id }}">

                    <input class="btn btn-primary" type="submit" name="" value="Guardar">
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <div id="map-travel">

            </div>
        </div>
    </div>


</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="/js/travels.js"></script>
<script type="text/javascript">
$(".chosen-select").chosen()
$('.remove_field_button').click(function(){
    $('.input_fields_wrap select:last').remove()
    $('.input_fields_wrap input:last').remove()
})

    $('.datepicker_auth').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });
    ref = 1
    function fill_ref_select(){
        $('.route-ref-id-'+ref).append('<option >Selecciona una referencia</option>')
        @foreach($references  as $geofence)
        @if( $geofence->gcat_id==4 OR $geofence->gcat_id==5)
        console.log('alguna')
        $('.route-ref-id-'+ref).append('<option value="{{ $geofence->id }}">{{ $geofence->name }}</option>')
        @endif

        @endforeach
        $(".input_fields_wrap").append('<div class="hide estimated-hour-'+ref+'">ss<input type="text" name="estimated-hour-'+ref+'" value="5"></input></div>'); //add input box

        ref++
    }
    fill_ref_select()
    var max_fields      = 10; //maximum input boxes allowed
       var wrapper         = $(".input_fields_wrap"); //Fields wrapper
       var add_button      = $(".add_field_button"); //Add button ID

       var x = 1; //initlal text box count
       $(add_button).click(function(e){ //on add input button click
         e.preventDefault();
           if(x < max_fields){ //max input box allowed
               x++; //text box increment
                $(wrapper).append('<select class="form-control state" toform="'+ref+'" name="state_id"><option value="">Selecciona un Estado</option><option value="1">Aguascalientes</option><option value="2">Baja California</option><option value="3">Baja California Sur</option><option value="4">Campeche </option><option value="5">Coahuila de Zaragoza </option><option value="6">Colima </option><option value="7">Chiapas </option><option value="8">Chihuahua </option><option value="9">Ciudad de México </option><option value="10">Durango </option><option value="11">Guanajuato </option><option value="12">Guerrero </option><option value="13">Hidalgo </option><option value="14">Jalisco </option><option value="15">Estado de México </option><option value="16">Michoacán </option><option value="17">Morelos </option><option value="18">Nayarit </option><option value="19">Nuevo León </option><option value="20">Oaxaca </option><option value="21">Puebla </option><option value="22">Querétaro </option><option value="23">Quintana Roo </option><option value="24">San Luis Potosí </option><option value="25">Sinaloa </option><option value="26">Sonora </option><option value="27">Tabasco </option><option value="28">Tamaulipas </option><option value="29">Tlaxcala </option><option value="30">Veracruz </option><option value="31">Yucatán </option><option value="32">Zacatecas </option><option value="33">Texas </option><option value="34">New Mexico </option><option value="35">Arizona </option><option value="36">California </option><option value="37">Louisiana </option><option value="38">Mississippi </option></select>');
               $(wrapper).append('<select name="route-ref-id-'+ref+'" class="form-control b5 route-ref-id-'+ref+'"></select>');

               fill_ref_select()
               stateChange()
           }
       });

       $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
         e.preventDefault(); $(this).parent('div').remove(); x--;
     })
function stateChange(){
    $('.state').change(function(){
            id_state = $(this).val();
            toform = $(this).attr('toform');

            console.log(toform)
            $.ajax({
                url:'/references/get',
                type:'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { id: id_state },
                success: function(references){
                    console.log('respuesta')
                    console.log(references.length)
                    /*
                    $('.location').empty() 
                    $('.routes').empty()
                    */
                    $('.route-ref-id-'+toform).empty()
                    $('.location').append('<option >Selecciona una locacion</option>')
                    if(references.length == 0){
                        console.log('cero')
                        console.log('route-ref-id-'+toform)
                        console.log('arriba')


                        $('.route-ref-id-'+toform).append('<option >Este estado no cuenta con referencias</option>')
                    }
                    $.each(references,function(id,reference){
                        console.log(reference.name)
                        console.log(reference['name'])
                        console.log('route-ref-id-'+toform)
                        $('.route-ref-id-'+toform).append('<option value="'+reference.id+'" >'+reference.name+'</option>')
                    })
                    stateChange()
                },
                error: function(data){
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            })
})
}
       stateChange()
 </script>
 <script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
 @endsection
