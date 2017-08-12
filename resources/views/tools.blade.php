@extends('layouts.master')
@section('content')

<style type="text/css">
      #map, html, body {
        padding: 0;
        margin: 0;
        height: 100%;
      }
      #panel {
        width: 200px;
        font-family: Arial, sans-serif;
        font-size: 13px;
        float: right;
        margin: 10px;
      }
      #color-palette {
        clear: both;
      }
      .color-button {
        width: 14px;
        height: 14px;
        font-size: 0;
        margin: 2px;
        float: left;
        cursor: pointer;
      }
      #delete-button {
      }
    </style>
<div class="mt10 page-content inset">
    <div class="row">
        <div class="col-md-4">
            <div class="mt10 wrapp">
                <div  >

                            <p>Crear Geocercas</p>
                            @if (session('geofence'))
                            <div class="alert alert-danger">
                                <ul>
                                        <li>
                                        Es necesario dibujar una geocerca en el mapa
                                    </li>
                                    </ul>
                            </div>
                            @endif
                            @include('partials/errors')
                            <form class="" action="geofences" method="post">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label   class="control-label">Nombre</label>
                                    <input name="name" class="form-control" type="text" value="{{ old('name') }}">
                                </div>
                                <input type="hidden" id="circle_lat" name="lat" value="">
                                <input type="hidden" id="circle_lng" name="lng" value="">
                                <input type="hidden" id="circle_radius" name="radius" value="">
                                <input type="hidden" id="poly_data" name="poly_data" value="">
                                <input type="hidden" id="color" name="color" value="">
                                <input type="hidden" id="client_id" name="id_client" value="{{ Auth::user()->client_id }}">
                                <input type="hidden" id="type" name="type" value="">
                                <div class="form-group">
                                    <label   class="control-label">Categoría</label>
                                <select class="form-control" id="category" name="gcat_id">
                                    #1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'
                                    <option value="4|#4B0082">Referencia</option>
                                    <option value="2|#32CD32">Patio</option>
                                    <option value="3|#e63535">Zona de Peligro</option>
                                    <option value="5|#e98535">Paradas autorizadas</option>
                                </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Ciudad</label>
                                    <input type="text" name="city" class="form-control city" value="">
                                </div>

                                <div class="form-group">
                                <label class="control-label">Estado</label>
                                <select class="form-control state" name="state_id">
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
                                </div>
                                <input type="submit" class="btn btn-primary"  value="Guardar">
                            </form>
                           <!-- <p id="datos"></p>-->
                        </div>

                <div class="clear"></div>
            </div> 
        </div>
        <div class="col-md-8">
            <div class="mt10 wrapp">
                <div class="col-md-12"  >
                    <div class="drawingManager">
                        <div>
        <button id="delete-button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
      </div>

                    </div>
                    <input id="pac-input" class="controls" type="text" placeholder="Buscar direcciones">
                    <div id="map" style="height:600px;"></div>
                </div>
                <div class="clear"></div>
            </div>

        </div>
    </div>
</div>
@stop
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw&libraries=drawing,places" type="text/javascript"></script>

<script src="js/drawing.js"></script>

@if (session()->has('flash_notification.message'))
<script type="text/javascript">
    swal("{!! session('flash_notification.message') !!}", "", "success")
</script>
@endif


<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@stop
