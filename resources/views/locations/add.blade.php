@extends('layouts.master')
@section('content')
<div class="mt10 page-content inset">
    <div class="row">
        <div class="col-md-12">
            <div class="wrapp">
                <div class="col-md-12"  >
                    <div class="drawingManager">
                        <div>
                            <button id="delete-button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                        </div>
                    </div>
                    <input id="pac-input" class="controls" type="text" placeholder="Buscar direcciones">
                    <div id="map" style="height:300px;"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="mt10 wrapp">
                <div class=" col-md-6">
                    <h3>Agregar ubicacion al cliente: {{ $subclient->name }}</h3>
                    @include('partials/errors')
                    <form class="" action="/geofences" method="post">
                        {!! csrf_field() !!}


                        <input type="hidden" id="circle_lat" name="lat" value="">
                        <input type="hidden" id="circle_lng" name="lng" value="">
                        <input type="hidden" id="circle_radius" name="radius" value="">
                        <input type="hidden" id="poly_data" name="poly_data" value="">
                        <input type="hidden" id="color" name="color" value="">
                        <input type="hidden" id="client_id" name="id_client" value="{{ Auth::user()->client_id }}">
                        <input type="hidden" id="type" name="type" value="">
                        <input type="hidden" id="type" name="subclient_id" value="{{ $subclient->id }}">
                        <div class="form-group">
                            <label  class="control-label">Tipo de geocerca</label>
                        <select class="form-control" id="category" name="gcat_id">
                            #1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'
                            <option value="1|#1E90FF">Cliente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label  class="control-label">Ciudad</label>
                        <input type="text" name="city" class="form-control city" value="">
                    </div>
                    <div class="form-group">
                        <label  class="control-label">Estado</label>
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nombre de la locación</label>
                        <input type="text" class="form-control" name="location_name" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Dirección</label>
                        <input type="text" class="form-control" name="direction" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telefono</label>
                        <input type="text" class="form-control" name="phone" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Telefono 2</label>
                        <input type="text" class="form-control" name="phone_2" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input id="multiple" class="form-control" type="text" name="email" value="">
                    </div>

                        <input class="btn btn-primary" type="submit"   value="Guardar">
                    </form>
                    <p id="datos"></p>
                </div>

                <div class="col-lg-6">
                    <table class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Nombre</td>
                                    <th>Tipo</td>
                                        <th>Categoria</td>
                                            <th>Estado</td>
                                                <th>Ciudad</td>
                                                    <th></td>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </table>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @stop
                            @section('script')
                            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw&libraries=drawing,places" type="text/javascript"></script>

                            <script src="/js/drawing.js"></script>
                            <script type="text/javascript">
                            $('#multiple').multipleInput();
                            </script>
                            @if (session()->has('flash_notification.message'))
                            <script type="text/javascript">
                            swal("{!! session('flash_notification.message') !!}", "", "success")
                            </script>
                            @endif


                            <script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
                            @stop
