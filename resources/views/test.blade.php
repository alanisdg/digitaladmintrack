@extends('layouts.master')

@section('content')
    <p id="power">0</p>
@stop

@section('footer')
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://104.236.115.50:3000');
        socket.on("test-channel:App\\Events\\EventName", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
    </script>
@stop
