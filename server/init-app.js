const eq = require('./utilities/utils');

const io = require('socket.io')(3000, {
    cors: {
        origin: ['http://127.0.0.1:5500', 'http://192.168.1.8:5500', 'http://127.0.0.1:8000/', 'http://127.0.0.1:3000']
    },
})

const equation = eq.generateDOM()

let users = {}, intervals = {}
let rooms = {
    javascript: {
        countdown: 500,
        equation: equation,
        users: {}
    }
}

intervals['javascript'] = setInterval(() => {

    io.to('javascript').emit('countdown', rooms['javascript'].countdown) // room user
    // io.emit('receive-message', filteredRoom) //for all user
    // socket.emit('receive-message', filteredRoom) //sakin lang
    // socket.broadcast.emit('receive-message', filteredRoom) // send except you
    
    --rooms['javascript'].countdown;
    console.log(rooms['javascript'].countdown)
    if(rooms['javascript'].countdown == 0){
        clearInterval(intervals['javascript'])
        console.log('GAME OVER')
    }

}, 1000);

io.on('connection', socket => {

    socket.on('join-room', (name, room_name) => {

        if(!rooms[room_name]){
            rooms[room_name] = {
                countdown: 60,
                equation: null,
                users: {}
            }
        }

        rooms[room_name] = {
            ...rooms[room_name],
            users:{
                ...rooms[room_name].users, [socket.id]: name
            }
        }
        socket.join(room_name);
        socket.emit('room-joined', rooms[room_name].users)
        socket.emit('equation', rooms[room_name].equation)
        socket.to(room_name).emit('room-joined', rooms[room_name].users)
     })

     socket.on('equation-answer', (answer) => {
        const isCorrect = isSorted(answer);

        if(isCorrect){
            rooms['javascript'].equation = eq.generateDOM()
            io.to('javascript').emit('equation', rooms['javascript'].equation)
        }

        socket.emit('distribute-answer', {
            correct: isCorrect
        })
      })

    socket.on('disconnect', () => {
        delete rooms['javascript'].users[socket.id]
        
        socket.broadcast.emit('user-disconnected', rooms['javascript'].users)
        console.log(`user disconnected ${socket.id}`)
    })

    function isSorted(answers) {
        let second_index;
        for (let first_index = 0; first_index < answers.length; first_index++) {
            second_index = first_index + 1;
            if (answers[second_index] - answers[first_index] < 0) return false;
        }
        return true;
    }

})
// -------------------------------------------------------------------------------------------
// notes
//client
//socket.on('chat-message') -> receive message.
//socket.emit('send-chat-message') -> send message

//server
//socket.on('send-chat-message') -> dito mapupunta yung sinend na message
//sa loob nyan may socket.broadcast.emit('chat-message') -> mag sesend ng message sa client

//server-room
//socket.to(room).emit('chat-message')