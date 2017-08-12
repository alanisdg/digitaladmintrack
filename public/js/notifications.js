var socket = io(':3000');
socket.on("messages", function(data){
    console.log('FROM SERVER',data);
    $.notify(data,{
        position: 'bottom right',
        className: 'info',
    });
})
socket.emit("message", 'Se autorizo un nuevo viaje')
