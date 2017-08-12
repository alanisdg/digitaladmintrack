var express = require('express')
app = express()
server = require('http').createServer(app)
io = require('socket.io').listen(server);

server.listen(3000)

io.sockets.on('connection',function(socket){
    socket.on('message',function(data){
        console.log(data)
        io.sockets.emit('messages', data);
    })
})
console.log('started')
