module.exports = {

    // binary to decimal
    status: function(num){
        return 'ay la lleva';
    },
    getQueryGeofences:function(references_route){
        console.log(references_route)
        references_o = JSON.parse(references_route);
        references_only = []
        // ACUMULAR LOS ID
        for(i=0; i<references_o.length; i++) {
            id_reference = Object.keys(references_o[i])
            timer_reference = references_o[i][id_reference]
            references_only.push(id_reference)
            
        }
        console.log('only')


        references = JSON.parse(references_route,origin_id,destination_id);
        references_array = []
        references_array.push(origin_id)
        

        // ACUMULAR LOS ID
        for(i=0; i<references.length; i++) {
            id_reference = Object.keys(references[i])
            timer_reference = references[i][id_reference]
             
            references_array.push(id_reference)
        }
        console.log('only')
        console.log(references_only)
        references_array.push(destination_id)
        // CONSTRUIR LA QUERY
        query = 'SELECT * FROM geofences WHERE id IN('
        for(i=0; i<references_array.length; i++) {

            query = query + references_array[i] +','
        }
        query = query.slice(0, -1);
        query = query + ')';
        var response = new Object();
        response['query'] = query;
        response['references'] = references_array;
        response['references_only'] = references_only;
        return response;
    },
    getOD:function(references_array,rows,origin_id,destination_id,references_only){
        console.log('getODfunction')
        console.log(origin_id)
        for (var t = 0; t < references_only.length; t++){
            console.log(references_only[t])
            lastReferenceID = references_only[t]
        }
        console.log(references_only)
        console.log(lastReferenceID + ' ultimas');
        for (var x = 0; x < references_array.length; x++) 
        {
            console.log(actual_id + ' de donde')
            if(references_array[x] == destination_id){
                    console.log('estamos en la ultima')
                }
            if(actual_id==null)
            {
                start = origin_id
            }else{
                start = actual_id
            }
            if(references_array[x]== start)
            {
                console.log('encontramos origen que es ' + references_array[x])
                console.log('encontramos sigue ' + references_array[x+1])
                
                console.log(rows.length)
                for (var o = 0; o < rows.length; o++) 
                {
                    console.log(rows[o].id)
                    if(rows[o].id== references_array[x])
                    {
                        if(rows[o].type == 'poly')
                        {
                            points = rows[o].poly_data
                            points = JSON.parse(points)
                                for (i = 0; i < points.length; ++i) 
                                    {
                                        lat_origen = points[i].lat
                                        lng_origen = points[i].lng
                                        name_origen = rows[o].name
                                                        id_origen = rows[o].id
                                    }
                        }else
                        {
                            lat_origen = rows[o].lat
                            lng_origen = rows[o].lng
                            name_origen = rows[o].name
                            id_origen = rows[o].id
                        }
                    }
                        console.log(rows[o].id + ' -- '+ references_array[x+1])
                    if(rows[o].id== references_array[x+1])
                    {
                        if(rows[o].type == 'poly')
                        {
                            points = rows[o].poly_data
                            points = JSON.parse(points)
                            for (i = 0; i < points.length; ++i) 
                            {
                                lat_1 = points[i].lat
                                lng_1 = points[i].lng
                                name_destino = rows[o].name
                                id_destino = rows[o].id
                            }
                        }else
                        {
                            console.log('el destino muls?')
                            lat_1 = rows[o].lat
                            lng_1 = rows[o].lng
                            name_destino = rows[o].name
                            id_destino = rows[o].id
                        }
                    }
                }
            }
        }
        var response = new Object();
        response['lat_origen'] = lat_origen;
        response['lng_origen'] = lng_origen;
        response['lat_1'] = lat_1;
        response['lng_1'] = lng_1;
        response['id_destino'] = id_destino;
        response['id_origen'] = id_origen;
        return response;
    }

}
