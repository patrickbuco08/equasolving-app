const axios = require('axios');
const pvp = require('./utilities/pvpService');

(async () => {
    const eq = require('./utilities/utils');

    const io = require('socket.io')(3000, {
        cors: {
            // origin: ['http://127.0.0.1:8000', 'http://127.0.0.1:3000']
            origin: ['http://192.168.1.215:8000', 'http://192.168.1.215:3000']
        }
    });

    let admin_bearer_token = null,
        admin = null,
        gameCoordinator = null,
        matches = {},
        matchIntervals = {},
        equationIntervals = {},
        matchCountdown = {},
        lobby = [],
        origin = 'http://192.168.1.215:8000';

    const equation = eq.generateDOM();

    if (!admin_bearer_token) {
        admin_bearer_token = await getBearerToken();
    }
    admin = await getAdmin();
    //console.log(admin.name);

    //start to find match
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

                // maximum mmr difference
                if (difference <= 50) {
                    return contestant;
                }
            });

            const second_contestant = second_contestants[0];

            //possible na start ang game
            if (second_contestant) {
                console.log('FIGHT! please wait');
                const roomID = generateRoomID();

                //inform them
                const versusScreen = await generateVersusScreen(first_contestant, second_contestant);
                io.to([first_contestant.socketID, second_contestant.socketID]).emit('match-found', roomID, versusScreen);

                clearInterval(gameCoordinator); //stop the interval

                await setMatch(first_contestant, second_contestant, roomID); //save data to Database
                //add delay to request (3-5 seconds) para makapag ready yung player

                console.log('Match Already Set... Moving to Arena...');
                // io.to([first_contestant.socketID, second_contestant.socketID]).emit('move-to-arena', {
                //     roomID,
                //     first_contestant,
                //     second_contestant
                // });

                // io.to(first_contestant.socketID).emit('move-to-arena', roomID, first_contestant);
                // io.to(second_contestant.socketID).emit('move-to-arena', roomID, second_contestant);

                //remove the matched contestant to lobby
                lobby = lobby.filter((lobbyUser) => {
                    return lobbyUser.socketID != first_contestant.socketID && lobbyUser.socketID != second_contestant.socketID;
                });

                //create match
                matches[roomID] = {
                    playerReady: 0,
                    gameStarted: false,
                    countdown: 4,
                    time: 90,
                    contestants: {},
                    equation: equation,
                    equationInterval: '',
                }

                matches[roomID].contestants[first_contestant.id] = {
                    id: first_contestant.id,
                    name: first_contestant.name,
                    mmr: first_contestant.mmr,
                    points: 0
                };

                matches[roomID].contestants[second_contestant.id] = {
                    id: second_contestant.id,
                    name: second_contestant.name,
                    mmr: second_contestant.mmr,
                    points: 0
                };

                console.log(matches[roomID]);

                //find match again
                gameCoordinator = setInterval(findMatch, 10000);
                findMatch();
            }
        }
    }

    function startMatchCountdown(room) {
        io.to(room).emit('initial-countdown', matches[room].countdown);
        console.log(matches[room].countdown);
        matches[room].countdown--;
        if (matches[room].countdown == 0) {
            clearInterval(matchCountdown[room]);

            startGame(room);
            matchIntervals[room] = setInterval(() => {
                startGame(room);
            }, 1000);
            // dito dapat yon : 178

        }
    }

    async function startGame(room) {
        io.to(room).emit('countdown', matches[room].time);
        console.log(matches[room].time);
        matches[room].time--;

        if (matches[room].time == 0) {
            clearInterval(matchIntervals[room]);
            clearInterval(equationIntervals[room]);
            console.log('game over');
            // announce the winner
            console.log('room', room);
            console.log('data', matches[room]);
            const userData = await saveMatch(room, matches[room]);
            io.to(room).emit('finished', userData);
        }
    }

    io.on("connection", (socket) => {
        console.log('INITIALIZED!');

        socket.emit("connection", 'connected!');


        // ARENA STRAT----------------------------------------------------------------------------
        socket.on('join-room', (room_id) => {

            if(!matches.hasOwnProperty(room_id)){
                return;
            }
            
            matches[room_id].playerReady++;
            console.log(matches[room_id].playerReady);

            //ibig sabihin nakapasok na yung dalawang player
            if (matches[room_id].playerReady == 2) {
                // initial start the game

                if (!matches[room_id].gameStarted) {
                    matches[room_id].gameStarted = true;
                    
                    setTimeout(() => {
                        startMatchCountdown(room_id);
                        matchCountdown[room_id] = setInterval(() => {
                            startMatchCountdown(room_id);
                        }, 1000);

                        //hindi to dito
                        equationIntervals[room_id] = setInterval(() => {
                            matches[room_id].equation = eq.generateDOM();
                            io.to(room_id).emit('new-equation', matches[room_id].equation);
                        }, 20000);
                    }, 1000);
                }

            }
            socket.join(room_id);
            socket.emit('room-joined', matches[room_id]); //send sayo
            // socket.to(room_id).emit('room-joined', 'fuck!') //send to all except you (broadcast)
        });

        socket.on('equation-answer', (user, answer) => {
            const isCorrect = isSorted(answer);

            if (isCorrect) {
                // stop interval equation
                clearInterval(equationIntervals[user.room_id]);

                matches[user.room_id].equation = eq.generateDOM();
                matches[user.room_id].contestants[user.id].points++;
                io.to(user.room_id).emit('update-score', matches[user.room_id], user.id);
                io.to(user.room_id).emit('new-equation', matches[user.room_id].equation);

                equationIntervals[user.room_id] = setInterval(() => {
                    matches[user.room_id].equation = eq.generateDOM();
                    io.to(user.room_id).emit('new-equation', matches[user.room_id].equation);
                }, 20000)
            }else{
                socket.emit('wrong-answer', isCorrect);
            }

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
                url: `${origin}/api/auth`,
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
                url: `${origin}/api/set-match`,
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

    async function saveMatch(room, data) {
        try {
            const response = await axios({
                headers: {
                    Authorization: `Bearer ${admin_bearer_token}`
                },
                method: 'POST',
                url: `${origin}/api/save-match`,
                data: {
                    room_id: room,
                    match: data
                }
            });
            console.log(response.data);
            return response.data;
        } catch (error) {
            console.log('error from setMatch', error);
            return null;
        }
    }

    async function generateVersusScreen(first_contestant, second_contestant) {
        try {
            const response = await axios({
                headers: {
                    Authorization: `Bearer ${admin_bearer_token}`
                },
                method: 'POST',
                url: `${origin}/api/skeleton/versus-screen`,
                data: {
                    first_contestant: first_contestant,
                    second_contestant: second_contestant
                }
            });
            console.log('THIS PART');
            return response.data;
        } catch (error) {
            console.log('error', error);
            return 'sorry something went wrong...';
        }
    }

    async function getAdmin() {
        try {
            const response = await axios({
                headers: {
                    Authorization: `Bearer ${admin_bearer_token}`
                },
                method: 'GET',
                url: `${origin}/api/get-user`,
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
