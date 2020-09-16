var inside = require('point-in-polygon');
var moment = require('moment');
var moment = require('moment-timezone');

module.exports = {

    // binary to decimal
    status: function(num){
        return 'ay la lleva';
    },
    getDistanceFromLatLonInKm:function(lat1,lon1,lat2,lon2){
        var R = 6371; // Radius of the earth in km
        var dLat = this.deg2rad(lat2-lat1);  // deg2rad below
        var dLon = this.deg2rad(lon2-lon1);
        var a =
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
        Math.sin(dLon/2) * Math.sin(dLon/2)
        ;
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c; // Distance in km
        return d;
    },
    deg2rad:function(deg) {
    return deg * (Math.PI/180)
    },
    odometro:function(odometro,anterior){
        if(odometro == 0){
            return 0;
        }else{
            odo = odometro - anterior;
            return odo;                    
        }
    },
    state:function(rows,lat,lng){ 
        for (index = 0; index < rows.length; ++index) {
             points = rows[index].polydata;
                points = JSON.parse(points)
                var points_polygon = []
                for (i = 0; i < points.length; ++i) {
                points_polygon.push([ points[i].lat,points[i].lng ])
                }
                var isinside = inside([ lat, lng ], points_polygon)
                if(isinside==true){
                    //console.log(' dentro de ' + rows[index].id)
                    return rows[index].id;
                }
        }
    },
    geofences:function(rows,lat,lng){
        geofence_in = '{'
        ides_geofence = []
        for (index = 0; index < rows.length; ++index) {
            type = rows[index].type;
            if(type=='circle'){
            //REVISAR GEOCERCA CIRCULAR
            lat1 = rows[index].lat;
            lng1 = rows[index].lng;
            lat2 = lat;
            lng2 = lng;
            distance = this.getDistanceFromLatLonInKm(lat1,lng1,lat2,lng2,inside)
            distance = distance * 1000;

            if(distance <=  rows[index].radius){
                geofence = "{" + rows[index].id + ":" + 1  + "}";
                num = '"'+rows[index].id+'"'
                ides_geofence.push(rows[index].id)
                geo = {};
                geo[num] = 1
                geofence_in  = geofence_in + num + ':' + 1 + ','
                //console.log('****INSIDE' + rows[index].name)
                }else{
                num = '"'+rows[index].id+'"'
                ides_geofence.push(rows[index].id)
                geo = {};
                geo[num] = 0
                geofence_in  = geofence_in + num + ':' + 0 + ','
                }
                }else{
                points = rows[index].poly_data;
                points = JSON.parse(points)
                var points_polygon = []
                for (i = 0; i < points.length; ++i) {
                points_polygon.push([ points[i].lat,points[i].lng ])
                }
                var isinside = inside([ lat, lng ], points_polygon)
                if(isinside==true){
                    //console.log('****INSIDE' + rows[index].name)
                    num = '"'+rows[index].id+'"'
                    ides_geofence.push(rows[index].id)
                    geo = {   };
                    geo[num] = 1
                    geofence_in  = geofence_in + num + ':' + 1 + ','
                    }else{
                        num = '"'+rows[index].id +'"'
                        ides_geofence.push(rows[index].id)
                        geo = {};
                        geo[num] = 0
                        geofence_in  = geofence_in + num + ':' + 0 + ','
                        }
                    }
                }
                geofence_in = geofence_in.substring(0, geofence_in.length - 1);

                if(geofence_in == ''){ 
                    geofence_in = '{'
                }
                geofence = geofence_in + '}';
                ides_geofence = ides_geofence;
                 var ret = new Object();
                ret['geofence'] = geofence;
                ret['ides_geofence'] = ides_geofence; 
                return ret;
    },
    build_query:function(packet,table,device_id){ 
        query = 'INSERT INTO '+table+' (imei,devices_id,buffer,lat,lng,altitude,created_at,fixTime,updateTime,serverTime,serviceType,messageType,speed,heading,sat,rssi,eventIndex, eventCode,acumCount,power_supply,power_bat,odometro_total,odometro_reporte,odometro,engine,Timebetween,tank1,state) VALUES';
                query += ' (';
                query += '"'+packet.MobileID+'",';
                query += '"'+device_id+'",';
                query += '"'+packet.buffer+'",';
                query += '"'+packet.lat+'",';
                query += '"'+packet.lng+'",';
                query += '"'+packet.Altitude+'",';
                query += '"'+moment(Date.now()).format('YYYY-MM-DD HH:mm:ss')+'",';
                query += '"'+packet.timeOfFix+'",';
                query += '"'+packet.updateTime+'",';
                query += '"'+moment(Date.now()).format('YYYY-MM-DD HH:mm:ss')+'",';
                query += '"'+packet.ServiceType+'",';
                query += '"'+packet.MessageType+'",';
                query += '"'+speed+'",';
                query += '"'+packet.Heading+'",';
                query += '"'+packet.Satellites+'",';
                query += '"'+packet.RSSI+'",';
                query += '"'+packet.EventIndex+'",';
                query += '"'+packet.EventCode+'",';
                query += '"'+packet.AccumCount+'",';
                query += '"'+packet.power_supply+'",';
                query += '"'+packet.power_bat+'",';
                query += '"'+packet.odometro_total+'",';
                query += '"'+packet.odometro_reporte+'",';
                query += '"'+packet.odometro+'",';
                query += '"'+packet.engine+'",';
                query += '"'+packet.timeBeetween+'",';
                query += '"'+packet.tank1+'",';
                query += '"'+packet.state+'"';
                query += ')';
                return query;
    }

}




