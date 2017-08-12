@extends('layouts.master')
@section('content')
<style type="text/css">
    #map{
        height: 600px;
    }
</style>
<div class="container">
<div class="row mt30">

    <div class="col-md-4" style="height:85vh; overflow:auto">
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Por Cliente</a></li>
                <li role="presentation" ><a href="#patio" aria-controls="home" role="tab" data-toggle="tab">Por Patio</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Por Caja</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                     <table class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                            <tr >
                                <th style="border-radius:3px 0px 0px 0px">Geocerca</th>
                                <th style="border-radius:3px 0px 0px 0px">Cajas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($geofences as $geofence)
                            <tr>
                                <td>
                                    @if ($geofence->type == 'poly')
                                        <input class="see_geofence" type="checkbox" ide="{{ $geofence->id }}" color="{{ $geofence->color }}" polydata="{{ $geofence->poly_data }}"  name="{{ $geofence->name }}"   tipo="{{ $geofence->type }}" value="">
                                        @else
                                        <input class="see_geofence" type="checkbox" ide="{{ $geofence->id }}" color="{{ $geofence->color }}" radius="{{ $geofence->radius }}" lat="{{ $geofence->lat }}" name="{{ $geofence->name }}" lng="{{ $geofence->lng }}"  tipo="{{ $geofence->type }}" value="">
                                    @endif
                                    {{ $geofence->name }}
                                
                                <td>
                                    <?php $go = 0; ?>
                                    @foreach($boxs as $device)
                                    @if($device->lastDestination['id']==$geofence->id)
                                    <?php $go++; ?>
                                    @endif
                                    @endforeach
                                    {{ $go }}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane " id="patio">
                     <table class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                            <tr >
                                <th style="border-radius:3px 0px 0px 0px">Geocerca</th>
                                <th style="border-radius:3px 0px 0px 0px">Cajas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patios as $geofence)
                            <tr>
                                <td>{{ $geofence->name }} </td> 
                                <td>
                                    <?php $go = 0; ?>
                                    @foreach($boxs as $device)
                                    @if($device->lastDestination['id']==$geofence->id)
                                    <?php $go++; ?>
                                    @endif
                                    @endforeach
                                    {{ $go }}
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="profile">
      
           <table class="table table-striped table-hover table-condensed">
                        <thead class="thead-inverse">
                            <tr >
                                <th style="border-radius:3px 0px 0px 0px">Nombre</th>
                                
                                <th>Ultima ubicación</th>
                                <th>Anclada</th>
                                <th></th>
                                <th style="border-radius:0px 3px 0px 0px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($boxs as $device)
                            <tr>
                                <td>{{ $device->name }} 
                               </td> 
                                <td>
                                @if(isset($device->travel->tstate->name))
                                @if($device->travel->tstate->name == 'En ruta')
                                En ruta hacia 
                                @endif
                                @endif
                                {{ $device->lastDestination['name'] }}

                                </td>
                                @if(isset( $device->boxs->name ))
                                <td>{{ $device->boxs->name }}</td>
                                @else
                                <td><span class="badge badge-blue">Disponible</span></td>
                                @endif
                                <td><a href="box/{{ $device->id}}" class="btn btn-primary btn-xs">Editar</a></td>
                                <td>
                                @if(isset($device->lastpacket->lat ))
                                <span lat="{{ $device->lastpacket->lat }}" lng="{{ $device->lastpacket->lng }}" class="btn goto btn-primary btn-xs">Ver</span>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-8">
     <div   id="lemap" style="height:85vh;"></div>
</div>
</div>
</div>
@endsection
@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5unzpQgOVgur7TbgtMpBdMKM7c7XGzWw" type="text/javascript"></script>
<script src="js/boxs.js"></script>

<script type="text/javascript">



var drawingManager;
var selectedShape;
var colors = ['#1E90FF', '#FF1493', '#32CD32', '#FF8C00', '#4B0082'];
var selectedColor;
var colorButtons = {};
 
function clearSelection() {
    if (selectedShape) {
         selectedShape.setMap(null);

    }
} 
function getAddress (latitude, longitude) {
    console.log(latitude)
    console.log(longitude)
    return new Promise(function (resolve, reject) {
        var request = new XMLHttpRequest();

        var method = 'GET';
        var url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' + latitude + ',' + longitude + '&sensor=true';
        var async = true;

        request.open(method, url, async);
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                if (request.status == 200) {
                    var data = JSON.parse(request.responseText);
                    console.log(request.responseText)
                    var address = data.results[0];
                    console.log(address)
                    resolve(address);
                }
                else {
                    reject(request.status);
                }
            }
        };
        request.send();
    });
};
function setSelection(shape,remove) {
    console.log('empieza setSelection')
    if(remove!=1){
        clearSelection();
    }


    selectedShape = shape;
    shape.setEditable(true);
    if(shape.type=='circle'){
        $('#circle_lat').val(shape.getCenter().lat())
        $('#circle_lng').val(shape.getCenter().lng())
        $('#circle_radius').val(shape.getRadius())
        $('#type').val('circle')
        getAddress(shape.getCenter().lat(), shape.getCenter().lng()).then(function(address){
            google_objects = Object.keys(address.address_components).length;
            $.each( address.address_components, function( key, component ) {
                if(component.types[0]== 'administrative_area_level_3' ){
                    city = component.long_name
                }
                if(component.types[0]== 'administrative_area_level_2'){
                    city = component.long_name
                }
                if(component.types[0]== 'administrative_area_level_1' ){
                    state = component.long_name
                }
            });
            console.log(state)
            $('.city').val(city)
            if(state=='Baja California'){
                $('.state option:eq(1)').prop('selected', true)
            }else{
                $('.state option:contains("'+state+'")').prop('selected', true)
            }

        }).catch(console.error);
        $('#datos').html('Radio: ' + parseFloat(shape.getRadius()).toFixed(2)+' mts <br>Centro: ('+parseFloat(shape.getCenter().lat()).toFixed(3)+','+parseFloat(shape.getCenter().lng()).toFixed(3)+')')
    }else if(shape.type=='polygon'){
        var vertices = shape.getPath(); // MVCArray
        var pointsArray = []; //list of polyline points
        var buff = '';
        for(var i =0; i < vertices.getLength(); i++){
            var xy = vertices.getAt(i); //LatLang for a polyline
            var item = { "lat" : xy.lat(), "lng":xy.lng()};
            buff += xy.lat()+','+xy.lng()+':';
            pointsArray.push(item);
        }
        console.log('poly')
        getAddress(pointsArray[0].lat, pointsArray[0].lng).then(function(address){
            console.log(address)
            google_objects = Object.keys(address.address_components).length;
            console.log(google_objects)
            $.each( address.address_components, function( key, component ) {
                console.log(component.types[0] + ' ->' + component.long_name  )
                if(component.types[0]== 'administrative_area_level_3' ){
                    city = component.long_name
                }
                if(component.types[0]== 'administrative_area_level_2'){
                    city = component.long_name
                }
                if(component.types[0]== 'administrative_area_level_1' ){
                    state = component.long_name
                }
            });
            $('.city').val(city)
            if(state=='Baja California'){
                $('.state option:eq(1)').prop('selected', true)
            }else{
                $('.state option:contains("'+state+'")').prop('selected', true)
            }
        }).catch(console.error);
        var poly_data = JSON.stringify(pointsArray);
        $('#poly_data').val(poly_data)
        $('#type').val('poly')
    }


    selectColor(shape.get('fillColor') || shape.get('strokeColor'));
}
function deleteSelectedShape() {
    if (selectedShape) {
        selectedShape.setMap(null);
    }
}
function toRad(Value) {
    /** Converts numeric degrees to radians */
    return Value * Math.PI / 180;
}
 function toDeg(Value) {
   return Value * 180 / Math.PI;
}
function selectColor(color) {
    console.log(color)
    $('#color').val(color)
    selectedColor = color;

    var circleOptions = drawingManager.get('circleOptions');
    circleOptions.fillColor = color;
    console.log(color + ' color')
    drawingManager.set('circleOptions', circleOptions);
    var polygonOptions = drawingManager.get('polygonOptions');
    polygonOptions.fillColor = color;
    drawingManager.set('polygonOptions', polygonOptions);
}
function setSelectedShapeColor(color) {
    if (selectedShape) {
        if (selectedShape.type == google.maps.drawing.OverlayType.POLYLINE) {
            selectedShape.set('strokeColor', color);
        } else {
            selectedShape.set('fillColor', color);
        }
    }
}
function makeColorButton(color) {
    var button = document.createElement('span');
    button.className = 'color-button';
    button.style.backgroundColor = color;
    $('#category')
    google.maps.event.addDomListener(button, 'click', function() {
        console.log('click')
        selectColor(color);
        setSelectedShapeColor(color);
    });
    return button;
}
function buildColorPalette() {

    selectColor('#4B0082');
}
function initialize() {
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(25.680389, -100.318796),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: true,
        mapTypeControl:true
    });
    var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });

        
    var polyOptions = {
        strokeWeight: 0,
        fillOpacity: 0.45,
        editable: true
    };
    // Creates a drawing manager attached to the map that allows the user to draw
    // markers, lines, and shapes.
    drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: null,

        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_RIGHT,
            drawingModes: [
                google.maps.drawing.OverlayType.CIRCLE,
                google.maps.drawing.OverlayType.POLYGON
                //google.maps.drawing.OverlayType.POLYLINE
            ]
    },
        circleOptions: polyOptions,
        polygonOptions: polyOptions,
        map: map
    });
    google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {

        if (e.type != google.maps.drawing.OverlayType.MARKER) {
            drawingManager.setDrawingMode(null);
            var newShape = e.overlay;
            console.log('empieza')
            newShape.type = e.type;
            google.maps.event.addListener(newShape, 'click', function() {
                setSelection(newShape);
                console.log(newShape)
            });

            google.maps.event.addListener(newShape, 'radius_changed', function(e){
                setSelection(newShape,1);
            });
            google.maps.event.addListener(newShape, 'center_changed', function(e){
                setSelection(newShape,1);
            });

            if(e.type=='polyline'){
                console.log('da')
                console.log(newShape.getPath().getArray());

                 newShape.getPath().getArray().splice(-1,1);

                //ida
                route =[]
                $.each(newShape.getPath().getArray(),function(a,point){

                    lat =point.lat();
                    lng =point.lng();
                    console.log(lat + ' '+ lng)
                    var lat1 = lat;
                        var lon1 = lng;
                        var d = .50;   //Distance travelled
                        var R = 6371;
                        var brng = 0;
                        var LatMax;
                        brng = toRad(brng);
                        var lat1 = toRad(lat1), lon1 = toRad(lon1);
                        var lat2 = Math.asin( Math.sin(lat1)*Math.cos(d/R) +
                                          Math.cos(lat1)*Math.sin(d/R)*Math.cos(brng) );

                        var lon2 = lon1 + Math.atan2(Math.sin(brng)*Math.sin(d/R)*Math.cos(lat1),
                                                 Math.cos(d/R)-Math.sin(lat1)*Math.sin(lat2));
                            lon2 = (lon2+3*Math.PI) % (2*Math.PI) - Math.PI;
                        lat2= toDeg(lat2);
                        lon2= toDeg(lon2);
                        console.log(lat2 + ' to '+ lon2)
                        b = {'lat':lat2,'lng':lon2}
                        route.push(b);
                })


                newShape.getPath().getArray().reverse()
                $.each(newShape.getPath().getArray(),function(a,point){
                    lat =point.lat();
                    lng =point.lng();
                    console.log(lat + ' ' +lng)
                    var lat1 = lat;
                        var lon1 = lng;
                        var d = .050;   //Distance travelled
                        var R = 6371;
                        var brng = 180;
                        var LatMax;
                        brng = toRad(brng);
                        var lat1 = toRad(lat1), lon1 = toRad(lon1);
                        var lat2 = Math.asin( Math.sin(lat1)*Math.cos(d/R) +
                                          Math.cos(lat1)*Math.sin(d/R)*Math.cos(brng) );

                        var lon2 = lon1 + Math.atan2(Math.sin(brng)*Math.sin(d/R)*Math.cos(lat1),
                                                 Math.cos(d/R)-Math.sin(lat1)*Math.sin(lat2));
                            lon2 = (lon2+3*Math.PI) % (2*Math.PI) - Math.PI;
                        lat2= toDeg(lat2);
                        lon2= toDeg(lon2);
                        console.log(lat2 + ' to '+ lon2)
                        b = {'lat':lat2,'lng':lon2}
                        route.push(b);
                })
                console.log('route')
                console.log(route)

                var route = JSON.stringify(route);
                $('#poly_data').val(route)

            }
            if(e.type=='polygon'){
                google.maps.event.addListener(newShape.getPath(), 'insert_at', function(e){
                    console.log('insert_at')
                    setSelection(newShape,1);
                });
                google.maps.event.addListener(newShape.getPath(), 'remove_at', function(e){
                    console.log('remove')
                    setSelection(newShape,1);
                });
                google.maps.event.addListener(newShape.getPath(), 'set_at', function(e){
                    setSelection(newShape,1);
                    console.log('set')
                })
                google.maps.event.addListener(newShape.getPath(), 'dragend', function(e){
                    setSelection(newShape,1);
                    console.log('dragend')
                });
            }
            setSelection(newShape);
        }
    });
    google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);

    google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
    console.log('buildColorPalettes')
    buildColorPalette();
    geofences_container = []
    geofences_labels = []
    alert('ok')
    show_geofence = function(radius,lat_,lng_,id,type,poly_data,color,name){
        console.log('drawing')
        console.log('mostar'+color)
        if(type=='circle'){
            l = parseFloat(lat_)
            ln = parseFloat(lng_)
            map.setZoom(13);
            map.panTo(new google.maps.LatLng(l, ln));
            draw_circle = new google.maps.Circle({
                center: {lat: l, lng: ln},
                radius: radius,
                strokeColor: "#cccccc",
                strokeOpacity: 0.8,
                strokeWeight: 0,
                fillColor: color,
                fillOpacity: 0.45,
                map: map
            })

            var myLatlng= new google.maps.LatLng(l,ln );


            var label= new MarkerWithLabel({
            position: myLatlng,
            map: map,
            icon: " ",
            labelContent: "<div>"+name+"</div>",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            zIndex: -1
        }); 

            draw_circle.set('id',id)
            geofences_container.push(draw_circle);
        }else{
            console.log(poly_data)
            var poly_data = JSON.parse(poly_data);
            console.log(poly_data)
            map.setZoom(13);
            map.panTo(new google.maps.LatLng(poly_data[0].lat, poly_data[0].lng));
            var myLatlng= new google.maps.LatLng(poly_data[0].lat,poly_data[0].lng );
        var label= new MarkerWithLabel({
            position: myLatlng,
            map: map,
            icon: " ",
            labelContent: "<div>"+name+"</div>",
            labelAnchor: new google.maps.Point(22, 0),
            labelClass: "labels", // the CSS class for the label
            labelStyle: {opacity: 0.75},
            zIndex: -1
        });

            var draw_circle = new google.maps.Polygon({
                paths: poly_data,
                fillColor: color,
                strokeWeight: 0,
                fillOpacity: 0.35,
                map: map
              });
              console.log('id ' +id)
              draw_circle.set('id',id)
              geofences_container.push(draw_circle);
        }

        geofences_labels.push(label);

    }
 
    $('#category').change(function(){
        color = $(this).val();
        color = color.split("|");
        color = color[1];
        selectColor(color);
        setSelectedShapeColor(color)
    })



}
google.maps.event.addDomListener(window, 'load', initialize);
 
 
$('.see_geofence').click(function(){
    console.log('y')
    if($(this).is(':checked')==true){
        if($(this).attr('tipo')=='circle'){
            console.log('color->' + $(this).attr('color'))
            show_geofence(parseFloat($(this).attr('radius')),$(this).attr('lat'),$(this).attr('lng'),$(this).attr('ide'),$(this).attr('tipo'),0,$(this).attr('color'),$(this).attr('name'))
        }else{
            show_geofence(0,0,0,$(this).attr('ide'),$(this).attr('tipo'),$(this).attr('polydata'),$(this).attr('color'),$(this).attr('name'))

        }
    }else{
        hide_geofence($(this).attr('ide'))
    }
})

console.log('empieza mapa')
var marker, map;
                    var myLatlng = new google.maps.LatLng(25.674873, -100.318432);
                    var mapOptions = {
                        zoom: 12,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }
                    map = new google.maps.Map(document.getElementById('lemap'), mapOptions);
m = []
            mwl = []
             @foreach($boxs  as $device)
             console.log('van')
             console.log('{{ $device->name }} ') 
             console.log('{{ $device->lastpacket }} ') 
             @if($device->lastpacket){
                console.log('si tiene')
             sec = {{ $device->status($device->lastpacket) }} * 60;
                    $(".timer"+{{$device->id}}).timer({ seconds: sec, });

                     var myLatlng{{ $device->id }}= new google.maps.LatLng({{ $device->lastpacket->lat   }},{{ $device->lastpacket->lng   }} );
                      var marker{{ $device->id }} = new google.maps.Marker({
                        position: myLatlng{{ $device->id }},
                        zIndex:9999999,
                        label: '{{$device->name}}',
                        icon:{
                            url:'http://usamexgps.com/images/truck3.png',
                            labelOrigin: new google.maps.Point(15, 45)
                        },
                        map:map,
                        rotation:50,
                        id:{{ $device->id }}
                    });

                     var label{{ $device->id }} = new MarkerWithLabel({
                        position: myLatlng{{ $device->id }},

                        icon: " ",
                        labelContent: "<div   onclick='showinfo({{$device->id}})'><span class='glyphicon @if($device->dstate_id==1) movement  @endif  glyphicon-circle-arrow-up fa-rotate-{{$device->lastpacket->heading}}' aria-hidden='true'></span> {{$device->name}} @if($device->boxs_id != null) -> {{ $device->boxs->name }} @endif</div><div class='none windowinfo window{{$device->id}}'>Velocidad: <span >{{$device->lastpacket->speed }}</span></div>",
                        labelAnchor: new google.maps.Point(22, 0),
                        labelClass: "labels", // the CSS class for the label
                        labelStyle: {opacity: 0.75},
                        id:{{ $device->id }}
                    });
                      mwl.push(label{{ $device->id }})
                m.push(marker{{ $device->id }})



             
             }
             @endif
             @endforeach
             var markerCluster = new MarkerClusterer(map, m, {
          averageCenter: true,
          gridSize:30
        });
$('.showGeo').click(function(){
    console.log($(this).attr('ide'))
})
$('.goto').click(function(){
                        console.log('gotoe')
                        console.log($(this).attr('lat')+'e')
                        console.log($(this).attr('lng'))
                        map.setZoom(15);
                        map.panTo(new google.maps.LatLng($(this).attr('lat'), $(this).attr('lng')));
                    })
 

</script>
<script> window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),]); ?> </script>
@endsection
