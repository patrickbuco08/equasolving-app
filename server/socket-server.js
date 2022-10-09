const io = require('socket.io')(3000, {
    cors: {
        origin: ['http://127.0.0.1:8000']
    }
})

const users = {}
const interval = {}
let gameStarted = false
let timerLoop = null

// io.emit('receive-message', message) //send to all

var countdown = 1000;
// setInterval(function() {
//   countdown--;
//   // io.sockets.emit('count-down', countdown);
//   io.to(556).emit('message', countdown);
// }, 1000);

io.on('connection', socket => {

    //when someone is trying to reconnect

    socket.on('join-room', (id, room) => {
        socket.join(room)

        socket.emit('message', `welcome fuck shit ${id}`);
    })

    socket.on('game-start', room => {
        setInterval(() => {
            console.log(countdown)
            // socket.emit('count-down', --countdown)
            socket.emit('count-down', --countdown)
        }, 1000);
    })

    socket.on('new-user', name => {
        console.log('new connection', name)
        users[socket.id] = name
        socket.broadcast.emit('user-connected', users)
    })
    socket.on('disconnect', () => {
        socket.broadcast.emit('user-disconnected', users[socket.id])
        delete users[socket.id]
    })
})

function countDownTimer() {
    countdown--;
}
