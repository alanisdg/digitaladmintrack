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