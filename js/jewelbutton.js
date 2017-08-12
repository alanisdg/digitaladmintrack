$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

$('.jewelButton').click(function(){
    event.preventDefault();
    $( ".notifications" ).toggleClass('none' );
    $( ".pyramid" ).toggleClass('none' );
    if($(".notifications").is(':visible')){
        on=true
    }else{
        on=false
    }
    $(document).mouseup(function (e)
    {
        var container = $(".notifications");
        var container2 = $(".jewelButton");

        if (!container.is(e.target)
        && container.has(e.target).length === 0 )
        {
            if(on==true){
                $( ".notifications" ).addClass('none' );
                $( ".pyramid" ).addClass('none' );
            }
        }
    });
})
layer = []
$('.show_traffic').change(function(){
    if($(this).is(':checked')){
        console.log('mos')
        var trafficLayer = new google.maps.TrafficLayer();
        trafficLayer.setMap(map);
        layer.push(trafficLayer);
    }else{
        console.log(layer)
        $.each(layer, function( index, value ) {
                layer[index].setMap(null)
        })
    }
})

$('.show_all_geofence').change(function(){
    if($(this).is(':checked')){
        $.ajax({
            url:'/geofences/get_all',
            type:'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { imei: $('#client_imei').val(),date_init: $('.init').val(),hour_init: $('.hour_init').val(),date_end: $('.end').val(),hour_end: $('.hour_end').val() },
            success: function(r){
                console.log(r)
                $.each(r['geofences'],function(g,geofence){
                    if(geofence.type=='circle'){
                         show_geofences(parseFloat(geofence.radius),geofence.lat,geofence.lng,geofence.id,geofence.type,0,geofence.color,geofence.name)
                    }else{
                         show_geofences(0,0,0,geofence.id,geofence.type,geofence.poly_data,geofence.color,geofence.name)

                    }
                })
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log(errors);

            }
        })
    }else{
        $.each(geofences_container, function( index, value ) {
                geofences_container[index].setMap(null)
        })
        $.each(geofences_labels, function( index, value ) {
                geofences_labels[index].setMap(null)
        })
    }
})
geofences_container = []
geofences_labels = []
 
show_geofences = function(radius,lat_,lng_,id,type,poly_data,color,name){
    console.log('jewel')
    if(type=='circle'){
        l = parseFloat(lat_)
        ln = parseFloat(lng_)

        draw_circle = new google.maps.Circle({
            center: {lat: l, lng: ln},
            radius: radius,
            strokeColor: "#cccccc",
            strokeOpacity: 0.8,
            strokeWeight: 0,
            fillColor: color,
            fillOpacity: 0.45,
            zIndex: 1,
            map: map
        })
        var myLatlng= new google.maps.LatLng(lat_,lng_ );
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
        geofences_labels.push(label);
    }else{
        var poly_data = JSON.parse(poly_data);

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
            map: map,
            zIndex: -1
          });
          draw_circle.set('id',id)
          geofences_container.push(draw_circle);
          geofences_labels.push(label);
    }

} 