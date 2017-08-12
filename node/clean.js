var dgram = require("dgram");
var moment = require('moment');
var moment = require('moment-timezone');
var mysql = require('mysql');
var request = require('request');
var io = require('socket.io')(3004);
var convertBase = require('./convertBase')
var tracking = require('./tracking')
var inside = require('point-in-polygon');

var Server = function(){
    var s = this;
    this.packet;
    this.mysql_conf = { user: "root", password: "56fg.tyyhY", database: "notes" };
    this.listener = dgram.createSocket("udp4");
    this.lport = 3002; //7777;

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

        console.log('AQUI EMPIEZA TODO EL DESMADRE')

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
            //OBETENER INFORMACION NECESARIA ANTES DE INGRESAR EL PAQUETE A BASE DE DATOS
            s.mysql_link.query('SELECT id,client_id,travel_id,name,geofences,boxs_id  FROM devices WHERE imei='+imei, function(err, rows ,fields)
            {
                if (err){callback(err,null); }else{
                    packet.device_id = rows[0].id
                    packet.device_name = rows[0].name
                    packet.client_id = rows[0].client_id
                }
                // REVISAR QUE NO ESTE REPETIDO EN VIVO, luego en normal
                s.mysql_link.query('SELECT COUNT(*) FROM  packets_lives WHERE imei="'+packet.MobileID+'" AND updateTime="'+packet.updateTime+'"',function(err, rows, fields){
                        if(err){  throw err; }
                        if(rows[0]['COUNT(*)'] >= 1)
                        {
                            console.log('REPETIDO EN VIVO')
                            packet.stored = 1
                            callback(null,packet);
                        }
                        else
                        {

                        }
                })
                


        } //:: FUNCTION getDeviceId

        getDeviceId(this.packet.MobileID,this.packet,function(err,packet)
        {
            if(err){
                // console.log('error: ' + err)
            }
        }//:: getDeviceId

    } //:: process_dgram

    onLoad();

} //:: var Server
var server = new Server();