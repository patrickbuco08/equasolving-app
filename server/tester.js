const {
    io
} = require("socket.io-client");

let matches = {};
let matchCountdown = {};
let equationChanger = {};
let matchIntervals = {};

matches['12345'] = {
    countdown: 3,
    time: 120,
    contestant_one: {
        id: 1,
        name: '',
        points: 0
    },
    contestant_one: {
        id: 2,
        name: '',
        points: 5
    },
    equation: '',
    equationInterval: '',
}


//initial start
startMatchCountdown('12345');
matchCountdown['12345'] = setInterval(() => {
    startMatchCountdown('12345');
}, 1000);


// matchCoordinator('12345');
// matchIntervals['12345'] = setInterval(() => { 
//     matchCoordinator('12345');
//  }, 1000);

function startMatchCountdown(room) {
    // io.to(room_id).emit('initial-countdown', matches[room].countdown);
    console.log(matches[room].countdown);
    matches[room].countdown--;
    if (matches[room].countdown == 0) {
        clearInterval(matchCountdown[room]);

        startGame(room);
        matchIntervals[room] = setInterval(() => {
            startGame(room);
        }, 1000);

    }
}

function startGame(room) {
    console.log(matches[room].time);
    matches[room].time--;

    if (matches[room].time == 0) {
        console.log('game over');
        clearInterval(matchIntervals[room]);
    }

}
