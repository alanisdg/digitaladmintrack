var dgram = require("dgram");
var moment = require('moment');
var moment = require('moment-timezone');
var mysql = require('mysql');
var request = require('request');
var io = require('socket.io')(3004);
var convertBase = require('./convertBase')
var tracking = require('./tracking')
var inside = require('point-in-polygon');
var functions = require('./functions')

var Server = function(){
    var s = this;
    this.packet;
    this.mysql_conf = { user: "root", password: "56fg.tyyhY", database: "notes" };
    this.listener = dgram.createSocket("udp4");
    this.lport = 3002; //7777;

     function onLoad(){
        s.load_mysql();
        s.load_listener();
    }

    this.load_mysql = function(){ s.mysql_up(); }
    this.mysql_up = function(){
        s.mysql_link = mysql.createConnection(s.mysql_conf);
        s.mysql_link.connect(function(err){
            if(err) { setTimeout(s.mysql_up, 2000); }
        });
        s.mysql_link.on('error', function(err){ if(err.code === 'PROTOCOL_CONNECTION_LOST'){ s.mysql_up(); } else { throw err; } });
    }

    this.load_listener = function(){
        s.listener.bind(s.lport);
        s.listener.on("listening", function(){ console.log("[Listener Server is running and waiting for packets on port: "+s.lport+"]"); });
        s.listener.on("message", function(packet,guest){

            buffer_str = packet.toString('hex');
            type = buffer_str.substring(0,1);
            if(type ==7){

                io.sockets.emit('message1', 'sobres');
            }else{
                s.process_dgram(packet,guest);
            }
        });
    }

    this.process_dgram = function(datagram,guest){
        console.log('[--- ('+moment().tz("America/Monterrey").format("YYYY-MM-DD HH:mm:ss")+'@'+guest.address+":"+guest.port+') ----]');

        var buffer_str = datagram.toString('hex');
        this.get_decimal= function(str){
            return parseInt(str,16)
        }
        this.parse_LatLng = function(v){
            d = parseInt(v,16); return (d < parseInt('7FFFFFFF', 16)) ? (d /  10000000) : 0 - ((parseInt('FFFFFFFF', 16) - d) / 10000000);
        }
 

        this.packet = new Object();
        this.packet.OptionsByte = buffer_str.substring(0,2);
        this.packet.MobileIDLength = buffer_str.substring(2,4);
        this.packet.MobileID = buffer_str.substring(4,19);
        this.packet.MobileIDLen = buffer_str.substring(20,22);
        this.packet.MobileIDType = buffer_str.substring(22,24);
        this.packet.ServiceType = buffer_str.substring(24,26);
        this.packet.MessageType = buffer_str.substring(26,28);
        this.packet.Secuence = buffer_str.substring(28,32);
        this.packet.timeOfFix =  moment(  this.get_decimal (buffer_str.substring(40,48))*1000 ).utcOffset('0').format("YYYY-MM-DD HH:mm:ss");
        this.packet.updateTime = moment(  this.get_decimal (buffer_str.substring(32,40))*1000 ).utcOffset('0').format("YYYY-MM-DD HH:mm:ss");
        this.packet.lat = this.parse_LatLng( buffer_str.substring(48,56) );
        this.packet.lng =this.parse_LatLng( buffer_str.substring(56,64) );
        this.packet.Altitude = this.get_decimal(buffer_str.substring(64,72));
        this.packet.Speed = this.get_decimal(buffer_str.substring(72,80));
        speed = this.packet.Speed*.036
        
        this.packet.Speed = parseFloat(speed).toFixed(1);
        //this.packet.Speed = speed; 
        this.packet.Heading = this.get_decimal(buffer_str.substring(81,84));
        this.packet.Satellites = this.get_decimal(buffer_str.substring(84,86));
        this.packet.FixStatus = buffer_str.substring(86,88);
        this.packet.Carrier = buffer_str.substring(88,92);
        this.packet.RSSI = convertBase.uintToInt(convertBase.bin2dec(convertBase.hex2bin( buffer_str.substring(92,96) )), 10);
        this.packet.CommState = buffer_str.substring(96,98);
        this.packet.HDOP = this.get_decimal(buffer_str.substring(98,100));
        this.packet.INPUTS = buffer_str.substring(100,102);
        this.packet.UnitStatus = buffer_str.substring(102,104);
        this.packet.EventIndex = this.get_decimal(buffer_str.substring(104,106));
        this.packet.EventCode = this.get_decimal(buffer_str.substring(106,108));
        this.packet.AccumCount = this.get_decimal(buffer_str.substring(108,110));
        this.packet.Spare = buffer_str.substring(110,112);
        this.packet.buffer = buffer_str;
        this.packet.Accum0 = this.get_decimal(buffer_str.substring(112,120));
        power_supply = this.packet.Accum0;
        power_supply = power_supply/1000;
        this.packet.power_supply = parseFloat(power_supply).toFixed(2);
        this.packet.Accum1 = this.get_decimal(buffer_str.substring(120,128));
        power_bat = this.packet.Accum1;
        power_bat = power_bat/1000;
        this.packet.power_bat = parseFloat(power_bat).toFixed(2);
        this.packet.Accum2 = this.get_decimal(buffer_str.substring(128,136));
        this.packet.Accum3 = this.get_decimal(buffer_str.substring(136,144));
        this.packet.odometro_total = this.packet.Accum3;
        this.packet.Accum4 = this.get_decimal(buffer_str.substring(144,152));
        this.packet.odometro_reporte = this.packet.Accum4;
        this.packet.odometro = 5;

        function getDeviceId(imei,packet, callback)
        {
            // OBTENER INFORMACION NECESARIA ANTES DE INGRESAR EL PAQUETE A BASE DE DATOS 
            s.mysql_link.query('SELECT id,client_id,travel_id,name,geofences,boxs_id,stop,stop_time  FROM devices WHERE imei='+imei, function(err, rows ,fields)
            {
                if (err){callback(err,null); }else{
                     
                    if(rows[0].boxs_id !=null){ packet.boxs_id = rows[0].boxs_id;  }else{ packet.boxs_id = false; }
                    packet.device_id = rows[0].id
                    packet.device_name = rows[0].name
                    console.log('NAME ' + packet.device_name)
                    packet.client_id = rows[0].client_id
                    packet.travel_id = rows[0].travel_id
                    packet.actual_geofences = rows[0].geofences
                    packet.device_id = rows[0].id
                    packet.device_name = rows[0].name
                    packet.client_id = rows[0].client_id
                    packet.stop = rows[0].stop
                    packet.stop_time = rows[0].stop_time
                }
                // REVISAR QUE NO ESTE REPETIDO EN VIVO
                s.mysql_link.query('SELECT COUNT(*) FROM  packets_lives WHERE imei="'+packet.MobileID+'" AND updateTime="'+packet.updateTime+'"',function(err, rows, fields){
                        if(err){  throw err; }
                        if(rows[0]['COUNT(*)'] >= 1)
                        {
                            console.log('REPETIDO EN VIVO ' + packet.updateTime + ' ' +packet.device_name)
                            packet.stored = 1
                            callback(null,packet);
                        }
                        else
                        {
                            // REVISAR REPORTE ANTERIOR PARA CALCULAR MOVIMIENTO Y ODOMETRO
                            s.mysql_link.query('SELECT * FROM packets WHERE devices_id ='+packet.device_id +' ORDER BY id DESC LIMIT 1', function(err, rows, fields){
                                if(isEmpty(rows)){ 
                                    packet.movement = false
                                    packet.dstate_id = 1
                                    packet.odometro_reporte = null;
                                    packet.odometro = null;
                                }else{ 
                                    this.previous_packet = new Object();
                                    this.previous_packet.id = rows['0'].id;
                                    previous_lat = rows['0'].lat;
                                    previous_lng  = rows['0'].lng;
                                    odo_anterior =  rows['0'].odometro_reporte;
                                    update_anterior =  rows['0'].updateTime;
                                    packet.odometro = functions.odometro(packet.odometro_reporte,odo_anterior); 
                                     

                                    distance = packet.odometro;
                                    // SI SE MUEVE MAS DE 300 mts y no tiene viaje 
                                    if(packet.Speed > 0){ 
                                    }
                                    if(distance > 100 && packet.travel_id == null){ 
                                        packet.movement = true
                                        packet.dstate_id = 1
                                        sql = 'update devices set porque="'+distance + '-' + packet.travel_id+'" where id='+packet.device_id;
                                         
                                        s.mysql_link.query(sql,function(err, rows, fields){

                                        })
                                    }else if(distance > 100 && packet.travel_id != null){
                                         
                                        // SI SE MUEVE MAS DE 300 mts y si tiene viaje
                                        packet.movement = true
                                        packet.dstate_id = 2
                                    }else if(distance < 100){ 
                                        // SI SE MUEVE MENOS DE 300 mts
                                        packet.movement = false
                                        packet.dstate_id = 4
                                    }

                                    // REVISAR STOP TIME 
                                    packet.stop_time = '';
                                    if(packet.stop==1){ 
                                        start = moment(update_anterior);
                                        finish = moment(packet.updateTime);
                                        go = finish.diff(start, 'minutes'); 
                                        total = packet.stop_time + go;
                                        packet.stop_time = total;
                                        sql_stop = 'update devices set stop_time='+total+' where id='+packet.device_id;
                                  
                                            s.mysql_link.query(sql_stop,function(err, rows, fields){})
                                        //esta detenido sumarle tiempo
                                    }
                                    if(packet.stop==0){
                                        if(packet.Speed < 2){
                                            packet.stop = 1;
                                            //se acaba de detener 
                                            sql_stop = 'update devices set stop=1, where id='+packet.device_id;
                                           
                                            s.mysql_link.query(sql_stop,function(err, rows, fields){})
                                        }
                                    }

                                    if(packet.stop==1){
                                        if(packet.Speed > 2){
                                            packet.stop = 0; 
                                            //se acaba de detener
                                            sql_stop = 'update devices set stop=0,stop_time=0 where id='+packet.device_id;
                                           
                                            s.mysql_link.query(sql_stop,function(err, rows, fields){})
                                        }
                                    }

                                    //::Termina stop time


                                }
                            }) //: termina revisar reporte anterior

                            // REVISAR EN QUE GEOCERCA ESTA
                            s.mysql_link.query('SELECT *  FROM geofences WHERE deleted_at IS null AND  id_client='+packet.client_id, function(err, rows ,fields){
                                if(err){  throw err; }
                                    geofence_detect = functions.geofences(rows,packet.lat,packet.lng,inside);
                                    packet.ides_geofence = geofence_detect['ides_geofence']
                                   
                                    packet.geofence = geofence_detect['geofence']
                                    packet.stored = 0
                                    callback(null,packet);
                            }) //: TERMINA REVISION DE GEOCERCAS
                        } //:: else no fue repetido en vivo
                })
            })
        } //:: FUNCTION getDeviceId 

        getDeviceId(this.packet.MobileID,this.packet,function(err,packet){
            if(err){ console.log(err)}
            if(packet.stored  == 0){
                // SE CONSTRUYEN LAS 3 QUERYS
                s.query_insert = functions.build_query(packet,'packets',packet.device_id);
                s.query_insert_live = functions.build_query(packet,'packets_lives',packet.device_id);

                if(packet.boxs_id != false){
                    s.query_insert_box = functions.build_query(packet,'packets_lives',packet.boxs_id);
                }
           
                s.mysql_link.query(s.query_insert, function(err, rows, fields){
                    if(err){ console.log("MySQL ERROR 'query_insert' "); throw err; }else{
                        console.log('-> INSERTADO EN BASE ' + packet.device_name)
                        
                        //---------> ENCENDIDO APAGADO
                        if(packet.EventCode == 20){
                            device_engine  = "UPDATE devices set engine=0 WHERE id="+packet.device_id;
                            s.mysql_link.query(device_engine, function(err, rows, fields){ if(err){throw err;} })
                        }
                        if(packet.EventCode == 21){
                            device_engine  = "UPDATE devices set engine=1 WHERE id="+packet.device_id;
                            s.mysql_link.query(device_engine, function(err, rows, fields){if(err){throw err;} })
                        }
                        //---------->::termina encendido apagado

                        // ACTUALIZAR EQUIPO COMO EL Dstate_id
                        s.mysql_link.query('UPDATE devices set dstate_id='+packet.dstate_id+' WHERE id='+packet.device_id, function(err, rows, fields){
                        })
                        //::termina actualizar equipo

                        //----------> HISTORIAL GEOCERCAS
                        packet.geofences_in =[];
                        packet.geofences_out =[];
                        if(packet.actual_geofences == null){
                            geofences = JSON.parse(packet.geofence)
                            //RECORRER LOS ID DE GEOCERCAS PARA VER CUAL ENTRO
                            for (i = 0; i < ides_geofence.length; ++i) {
                                // SI ENTRO GUARDAR EL SIGNES COMO ENTRADA
                                if(geofences[ides_geofence[i]] == 1){ 
                                    packet_id = rows.insertId;
                                    device_id = packet.device_id;
                                    geofence_id = ides_geofence[i];


                                    query = 'INSERT INTO signes (packet_id,geofence_id,device_id,status,updateTime)values('+packet_id+','+geofence_id+','+device_id+',1,"'+packet.updateTime+'")';
                                

                                    s.mysql_link.query(query, function(err, rows, fields){
                                    })
                                }else{
                                }
                            }
                        }else{
                            //GEOCERCAS ACTUALES
                            actual_geofences = JSON.parse(packet.actual_geofences)
                            
                            //EN QUE GEOCERCA ESTA
                            geofences = JSON.parse(packet.geofence)
                            

                            //ID DEL ULTIMO PAQUETE
                            packet_id = rows.insertId;
                            

                            //idesgeofence
                            
                            for (i = 0; i < ides_geofence.length; ++i) { 
                                if(actual_geofences[ides_geofence[i]] == 1 && geofences[ides_geofence[i]] ==1){
                                    //console.log('pendientito')
                                    geofence_id = ides_geofence[i]
                                    // SI SE HIZO LA GEOCERCA CON EL EQUIPO DENTRO DE LA GEOCERCA, GUARDAR SIGNES SIEMPRE Y CUANDO NO HAYA UN 1
                                    /*s.mysql_link.query('SELECT *  FROM signes WHERE device_id="'+packet.device_id+'" AND geofence_id="'+geofence_id+'"', function(err, rows ,fields){
                                        if(err){  throw err; }
                                            if(isEmpty(rows)){
                                                console.log('pendiente')
                                                /*
                                                packet_id = rows.insertId;
                                                device_id = packet.device_id;
                                                geofence_id = ides_geofence[i];
                                                console.log(packet.device_name + ' salio de san jose')
                                                query = 'INSERT INTO signes (packet_id,geofence_id,device_id,status,updateTime)values('+packet_id+','+geofence_id+','+device_id+',1,"'+packet.updateTime+'")';
                                                io.sockets.emit('geocerca'+packet.client_id,  {
                                                    response:[
                                                        geofence_id,
                                                        packet.device_name,
                                                        'in'
                                                    ]
                                                });
                                                s.mysql_link.query(query, function(err, rows, fields){
                                                }) 
                                            }else{
                                                console.log('pendiente')
                                            }
                                    }) */
                                }
                                if(actual_geofences[ides_geofence[i]] == 0 && geofences[ides_geofence[i]] ==0){
                                     
                                }
                                if(actual_geofences[ides_geofence[i]] == 1 && geofences[ides_geofence[i]] ==0){
                                     
                                    packet_id = rows.insertId;
                                    device_id = packet.device_id;
                                    geofence_id = ides_geofence[i];
                                    query = 'INSERT INTO signes (packet_id,geofence_id,device_id,status,updateTime)values('+packet_id+','+geofence_id+','+device_id+',0,"'+packet.updateTime+'")';
                                    io.sockets.emit('geocerca'+packet.client_id,  {
                                        response:[
                                            geofence_id,
                                            packet.device_name,
                                            'out'
                                        ]
                                    });
                                    //cambiamos in por out
                                    //packet.geofences_in.push(geofence_id)
                                    packet.geofences_out.push(geofence_id)
                                    s.mysql_link.query(query, function(err, rows, fields){
                                    })
                                }
                                if(actual_geofences[ides_geofence[i]] == 0 && geofences[ides_geofence[i]] ==1){
                                    
                                    packet_id = rows.insertId;
                                    device_id = packet.device_id;
                                    geofence_id = ides_geofence[i];
                                    query = 'INSERT INTO signes (packet_id,geofence_id,device_id,status,updateTime)values('+packet_id+','+geofence_id+','+device_id+',1,"'+packet.updateTime+'")';
                                    io.sockets.emit('geocerca'+packet.client_id,  {
                                        response:[
                                            geofence_id,
                                            packet.device_name,
                                            'in'
                                        ]
                                    });
                                    packet.geofences_in.push(geofence_id)
                                    s.mysql_link.query(query, function(err, rows, fields){
                                    })
                                }
                            }
                        }

                        if(packet.geofence  ){
                            s.mysql_link.query("UPDATE devices set geofences ='"+packet.geofence+"'  WHERE id="+packet.device_id, function(err, rows, fields){
                                // console.log('SE ACTUALIZO DEVICE 1')
                            })
                        }else{
                            // DE LO CONTRARIO PONERLA EN 0
                              s.mysql_link.query('UPDATE devices set geofences = null WHERE id='+packet.device_id, function(err, rows, fields){
                            // console.log('SE ACTUALIZO DEVICE 2')
                        })
                        }
                        //---------->::Termina historial geocercas


                        // TRACKING 
                        console.log('travel'+packet.travel_id)
                        if(packet.travel_id != null){
                            console.log('si tiene viaje')
                            //1er PASO TRAERSE LA INFO DEL VIAJE
                            s.mysql_link.query("SELECT id,route_id,driver_id,actual_id,tcode_id,device_id,tstate_id FROM travels WHERE id= "+packet.travel_id, function(err, rows, fields){
                                if(err){ console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â"); throw err; }
                                else{
                                    console.log('x')
                                    driver_id = rows[0].driver_id
                                    actual_id = rows[0].actual_id
                                    tcode_id = rows[0].tcode_id
                                    travel_id = rows[0].id
                                    s.mysql_link.query("SELECT origin_id,destination_id,references_route FROM routes WHERE id= "+rows[0].route_id, function(err, rows, fields){
                                        if(err){ console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â"); throw err;}
                                        else{
                                            origin_id = rows[0].origin_id;
                                            destination_id = rows[0].destination_id;
                                            console.log(packet.geofences_in)

                                            // SALIDAS
                                            for (i = 0; i < packet.geofences_out.length; ++i) {
                                                console.log(packet.geofences_out[i])
                                                if(packet.geofences_out[i] == rows[0].origin_id){
                                                     //comenzo
                                                     console.log('COMIENZA VIAJE')
                                                     update_travel = 'UPDATE travels set tstate_id=2 where id='+packet.travel_id
                                                s.mysql_link.query(update_travel, function(err, rows, fields){ if(err){ console.log("MySQL ERROR 'update_travel' "); throw err; } })
                                                    io.sockets.emit('travel_start'+packet.client_id, packet.device_id );
                                                }//:: termina termino viaje
                                                if(packet.geofences_out[i] == rows[0].destination_id){
                                                    console.log('TERMINA VIAJE')
                                                        // SI ES SALIDA

                                                        // th = "INSERT INTO thits (travel_id,tcode_id,packet_id,geofence_id,device_id)values("+packet.travel_id+","+tcode_id+","+packet_id+","+id_destino+","+packet.device_id+")";
                                                        // s.mysql_link.query(th, function(err, rows, fields){ })
                                             
                                                        //q = 'UPDATE travels set actual_id='+rows[0].destination_id+' WHERE id='+packet.travel_id;
                                                        // s.mysql_link.query(q, function(err, rows, fields){  console.log('SE ACTUALIZO DEVICE 1') })

                                                       
                                                        update_driver = "UPDATE drivers set status=0 WHERE id="+driver_id;
                                                        update_device = "UPDATE devices set status=0, travel_id=null,boxs_id=null,tcode_id=null where id="+packet.device_id;
                                                        update_box = "UPDATE devices set status=0, geofences="+ "'{"+ '"'+rows[0].destination_id+'"'+ ":1}' , travel_id=null,boxs_id=null where id=" +packet.boxs_id ;

                                                        s.mysql_link.query(update_driver, function(err, rows, fields){
                                                        if(err){console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â");throw err; } })
                                                            
                                                        s.mysql_link.query(update_device, function(err, rows, fields){
                                                        if(err){ console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â"); throw err; } })
                                                    
                                                        s.mysql_link.query(update_box, function(err, rows, fields){
                                                        if(err){ console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â"); throw err; } })
                                            
                                                        update_travel = 'UPDATE travels set tstate_id=4 where id='+packet.travel_id
                                                        s.mysql_link.query(update_travel, function(err, rows, fields){ if(err){ console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â"); throw err; } })
                                                        io.sockets.emit('travel_end'+packet.client_id, packet.device_id );
                                                       
                                                }//:: termina termino viaje
                                            }

                                            //ENTRADAS
                                            for (i = 0; i < packet.geofences_in.length; ++i) {
                                            console.log(' el for')
                                            console.log(packet.geofences_in[i] + ' - ' + rows[0].origin_id)

                                            //rumbo a origen tstate_id = 1 por salir

                                            //COMENZO A CARGAR tstate_id = 8 cargando

                                            //TERMINO DE CARGAR SALIO A VIAJE tstate_id = 2 en ruta

                                            //COMENZO A DESCARGAR tstate_id = 9 descargando

                                            //TERMINO DE DESCARGAR TERMINO VIAJE tstate_id =4 viaje terminado


                                            if(packet.geofences_in[i] == rows[0].origin_id){
                                                console.log('COMIENZA CARGA')
                                                //('COMENZO VIAJE A CARGAR ' + rows[0].origin_id)
                                                
                                                                    console.log('!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!comenzo ' + packet.device_id)
                                                                    //io.sockets.emit('travel_start'+packet.client_id, packet.device_id );
                                                                    update_travel = 'UPDATE travels set tstate_id=8 where id='+packet.travel_id
                                                s.mysql_link.query(update_travel, function(err, rows, fields){ if(err){ console.log("MySQL ERROR 'update_travel' "); throw err; } })
                                                io.sockets.emit('carga_start'+packet.client_id, packet.device_id );
                                                }
                                                //TERMINO VIAJE
                                                //console.log(packet.geofences_in[i] + ' ***-*** ' + rows[0].destination_id)
                                                if(packet.geofences_in[i] == rows[0].destination_id){
                                                    //COMENZO A DESCARGAR
                                                    console.log('COMIENZA DESCARGA')
                                                    update_travel = 'UPDATE travels set tstate_id=9 where id='+packet.travel_id
                                                s.mysql_link.query(update_travel, function(err, rows, fields){ if(err){ console.log("MySQL ERROR 'update_travel' "); throw err; } })
                                                    io.sockets.emit('descarga_start'+packet.client_id, packet.device_id );
                                                }
                                                
                                            }//::termina for
                                        }
                                    })
                                }
                            })

                        }
                        //::Termina tracking
                        
                        // EMIT PACKET
                        io.sockets.emit('message'+packet.client_id, packet);
                        //:: emit packet

                        // INSERTA EN VIVO
                        s.mysql_link.query(s.query_insert_live, function(err, rows, fields){
                            if(err){ console.log("MySQL ERROR 'query_insert' "); throw err; }
                            console.log('-> INSERTADO EN VIVO ' + packet.device_name)
                            // REGRESA ACK
                            s.return_ack(packet,guest.port,guest.address);
                        })

                        // INSERTA BOX
                        if(packet.boxs_id != false){
                            s.mysql_link.query(s.query_insert_box, function(err, rows, fields){
                                if(err){
                                    console.log("MySQL INSERT ERROR DE ESTE TAMAĂO ââžââżââ˝â");
                                    throw err;
                                }
                            })
                        } //:: termina inserta box
                    }

                }) //:: Termina s.query_insert
            }else{
                // FUE CON packetstored = 1
                s.return_ack(packet,guest.port,guest.address); 
            } //::packetstored
         })
    } //:: process_dgram


this.return_ack = function(packet,port,address){
    
    ackResponse =  packet.OptionsByte + packet.MobileIDLength + packet.MobileID +"f"+ packet.MobileIDLen + packet.MobileIDType + '0201' + packet.Secuence + '020000000000'
    
    

    ackResponse = new Buffer(ackResponse.toString('hex'),"hex")
    
    console.log(ackResponse)



    s.listener.send(ackResponse, 0, 22, port, address, function(err, bytes){
        if(err){
            console.log(err)
        }else{ 
            console.log('-> ACK TERMINA ' + packet.device_name)
            console.log(' ')
            console.log(' ') 
        }
    });
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
        return false;
    }

    return true;
}

onLoad();

} //:: var Server
var server = new Server(); 