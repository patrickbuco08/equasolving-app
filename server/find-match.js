const axios = require('axios');
const pvp = require('./utilities/pvpService');

(async () => {
    const eq = require('./utilities/utils');

    const io = require('socket.io')(3000, {
        cors: {
            origin: ['http://127.0.0.1:8000', 'http://127.0.0.1:3000']
        }
    });

    let admin_bearer_token = null,
        admin = null,
        gameCoordinator = null,
        matches = {},
        matchIntervals = {},
        matchCountdown = {},
        lobby = [];

    const equation = eq.generateDOM()
    // http://127.0.0.1:8000/find-match?id=1&name=user1&mmr=510

    if (!admin_bearer_token) {
        admin_bearer_token = await getBearerToken();
    }
    admin = await getAdmin();
    console.log(admin.name);

    gameCoordinator = setInterval(findMatch, 6000);
    findMatch();

    async function findMatch() {
        if (lobby.length >= 2) {
            console.log('finding....');

            const first_contestant = lobby[Math.floor(Math.random() * lobby.length)];
            console.log('first_contestant', first_contestant);

            const remaining_contestant = lobby.filter((lobbyUser) => {
                return lobbyUser.id != first_contestant.id;
            });

            const second_contestants = remaining_contestant.filter((contestant) => {
                const difference = Math.abs(first_contestant.mmr - contestant.mmr); //make it positive integer

                //ibig sabihin pasok sa elo
                if (difference <= 10) {
                    return contestant;
                }
            });

            const second_contestant = second_contestants[0];

            //possible na start ang game
            if (second_contestant) {
                console.log('FIGHT! please wait');
                const roomID = generateRoomID();
                // const roomID = '12345';

                //inform them
                io.to([first_contestant.socketID, second_contestant.socketID]).emit('match-found', {
                    first_contestant,
                    second_contestant
                });

                clearInterval(gameCoordinator); //stop the interval

                await setMatch(first_contestant, second_contestant, roomID); //save data to Database
                //add delay to request (3-5 seconds) para makapag ready yung player

                console.log('Match Already Set...');
                io.to([first_contestant.socketID, second_contestant.socketID]).emit('move-to-arena', {
                    roomID,
                    first_contestant,
                    second_contestant
                }); //move contestants to arena

                io.to(first_contestant.socketID).emit('move-to-arena', roomID, first_contestant);
                io.to(second_contestant.socketID).emit('move-to-arena', roomID, second_contestant);

                //remove the matched contestant to lobby
                lobby = lobby.filter((lobbyUser) => {
                    return lobbyUser.socketID != first_contestant.socketID && lobbyUser.socketID != second_contestant.socketID;
                });

                //create match
                matches[roomID] = {
                    countdown: 3,
                    time: 30,
                    contestants: {},
                    equation: equation,
                    equationInterval: '',
                }

                matches[roomID].contestants[first_contestant.id] = {
                    id: first_contestant.id,
                    name: first_contestant.name,
                    points: 0
                };

                matches[roomID].contestants[second_contestant.id] = {
                    id: second_contestant.id,
                    name: second_contestant.name,
                    points: 0
                };

                console.log(matches[roomID]);

                matchIntervals[roomID] = setInterval(() => {
                    io.to(roomID).emit('countdown', matches[roomID].time);

                    --matches[roomID].time;
                    if (matches[roomID].time == 0) {
                        clearInterval(matchIntervals[roomID]);
                        console.log('GAME OVER');
                        // announce the winner.
                    }

                }, 1000);

                //implement 3,2,1 countdown sa match
                // also, the 1 min and 30 seconds match

                //find match again
                gameCoordinator = setInterval(findMatch, 10000);
                findMatch();
            }
        }
    }

    io.on("connection", (socket) => {
        console.log('INITIALIZED!');

        socket.emit("connection", 'connected!');


        // ARENA STRAT----------------------------------------------------------------------------
        socket.on('join-room', (room_id) => {
            socket.join(room_id);
            socket.emit('room-joined', matches[room_id]); //send sayo
            // socket.to(room_id).emit('room-joined', 'fuck!') //send to all except you (broadcast)
        });

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
        // ARENA END------------------------------------------------------------------------------


        // FIND MATCH START
        socket.on("find-match", (user) => {
            // check if the user is already in the lobby
            const userExistInLobby = lobby.some((lobbyUser) => lobbyUser.id == user.id || lobbyUser.socketID == user.socketID);
            if (!userExistInLobby) {
                lobby = [...lobby, user];
            }
            socket.join("waiting-area");
            console.log('new find match', lobby);
        })

        socket.on("cancel-find-match", (user) => {
            lobby = lobby.filter((lobbyUser) => lobbyUser.id !== user.id);
            socket.leave("waiting-area");
            console.log('cancel find match', lobby);
        });
        // FIND MATCH END---------------------------------------------------------------------------

        socket.on("disconnect", () => {
            lobby = lobby.filter((user) => user.socketID !== socket.id);
            socket.leave("waiting-area");
            console.log('disconnected', lobby);
        });

        function isSorted(answers) {
            let second_index;
            for (let first_index = 0; first_index < answers.length; first_index++) {
                second_index = first_index + 1;
                if (answers[second_index] - answers[first_index] < 0) return false;
            }
            return true;
        }

    })

    // FUNCTIONS
    async function getBearerToken() {
        try {
            const response = await axios({
                method: 'POST',
                url: 'http://127.0.0.1:8000/api/auth',
                data: {
                    email: 'patrick.buco@gmail.com',
                    password: 'password'
                },
            });
            console.log(response.data.access_token);
            return response.data.access_token;
        } catch (error) {
            console.log('error', error);
        }
    }

    // set match
    async function setMatch(first_contestant, second_contestant, room_id) {
        try {
            const response = await axios({
                headers: {
                    Authorization: `Bearer ${admin_bearer_token}`
                },
                method: 'POST',
                url: 'http://127.0.0.1:8000/api/set-match',
                data: {
                    first_contestant: first_contestant,
                    second_contestant: second_contestant,
                    room_id: room_id
                }
            });

            console.log(response.data);

        } catch (error) {
            console.log('error from setMatch', error);
        }
    }

    async function getAdmin() {
        try {
            const response = await axios({
                headers: {
                    Authorization: `Bearer ${admin_bearer_token}`
                },
                method: 'GET',
                url: 'http://127.0.0.1:8000/api/get-user',
            });
            return response.data;
        } catch (error) {
            console.log('error', error);
        }
    }

    // functions
    function generateRoomID() {
        let s4 = () => {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        //return id of format 'aaaaaaaa'-'aaaa'-'aaaa'-'aaaa'-'aaaaaaaaaaaa'
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
    }

})();
