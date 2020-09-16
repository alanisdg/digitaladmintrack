
var io = require('socket.io')(3011);

io.on('connection', function (socket) {
  console.log('conectes d')
  socket.on('act', function (row) {
        socket.broadcast.emit('update row', row);
    });

  socket.on('mensaje', function (row) {
        socket.broadcast.emit('res', row);
    });

  socket.on('mensajeall', function (row) {
        io.emit('responsemensaje', row);
    });


  socket.broadcast.emit('user connected');
});