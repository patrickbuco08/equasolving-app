const io = require('socket.io')(3000, {
    cors: {
        origin: ['http://127.0.0.1:8000']
    }
});


io.on("connection", (socket) => { 
    // send a message to the client
    socket.emit("hello", "world");

    // receive a message from the client
    socket.on("howdy", (arg) => { 
        console.log(arg) //prints "stranger"
     })
 });