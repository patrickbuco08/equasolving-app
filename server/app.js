const eq = require('./utilities/utils');

const io = require('socket.io')(3000, {
    cors: {
        origin: ['http://127.0.0.1:8000', 'http://127.0.0.1:3000']
    }
});

const equation = eq.generateDOM()

let users = {},
    intervals = {}
let rooms = {
    javascript: {
        countdown: 500,
        equation: equation,
        users: {}
    }
}

let matches = {
    '12345': {
        countdown: 3,
        time: 120,
        contestants: {
            '1': {
                id: 1,
                name: 'user1',
                points: 0
            },
            '2': {
                id: 2,
                name: 'user2',
                points: 0
            }
        },
        equation: equation,
        equationInterval: '',
    }
};

const room = '12345';

// intervals[room] = setInterval(() => {

//     io.to(room).emit('countdown', rooms[room].countdown) // room user
//     // io.emit('receive-message', filteredRoom) //for all user
//     // socket.emit('receive-message', filteredRoom) //sakin lang
//     // socket.broadcast.emit('receive-message', filteredRoom) // send except you

//     --rooms[room].countdown;
//     console.log(rooms[room].countdown)
//     if(rooms[room].countdown == 0){
//         clearInterval(intervals[room])
//         console.log('GAME OVER')
//     }

// }, 1000);

io.on("connection", (socket) => {

    socket.on('join-room', (room_id) => {
        socket.join(room_id);
        socket.emit('room-joined', matches[room_id]); //send sayo
        // socket.to(room_id).emit('room-joined', 'fuck!') //send to all except you (broadcast)
    })

    socket.on('equation-answer', (user, answer) => {
        const isCorrect = isSorted(answer);

        if (isCorrect) {
            matches[user.room].equation = eq.generateDOM();
            matches[user.room].contestants[user.id].points++;
            io.to(user.room).emit('update-score', matches[user.room]);
            io.to(user.room).emit('new-equation', matches[user.room].equation);
        }

        socket.emit('wrong-answer', {
            correct: isCorrect
        })
    });

    socket.on('disconnect', () => {
        // delete rooms['javascript'].users[socket.id];
        // socket.broadcast.emit('user-disconnected', rooms['javascript'].users);
        console.log(`user disconnected ${socket.id}`);
    })

    function isSorted(answers) {
        let second_index;
        for (let first_index = 0; first_index < answers.length; first_index++) {
            second_index = first_index + 1;
            if (answers[second_index] - answers[first_index] < 0) return false;
        }
        return true;
    }
});
