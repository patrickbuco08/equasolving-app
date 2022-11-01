const axios = require('axios');
const pvp = require('./utilities/pvpService');

(async () => {
    const io = require('socket.io')(3000, {
        cors: {
            origin: ['http://127.0.0.1:8000', 'http://127.0.0.1:3000']
        }
    });
    let admin_bearer_token = 5;
    let admin = null;
    let intervals = {};

    if (!admin_bearer_token) {
        admin_bearer_token = await getBearerToken();
        admin = await getAdmin();
    }

    let lobby = [{
        id: 2,
        socketID: '423524238423',
        name: 'Gem Cuevas',
        mmr: 538
    }];



    let contestant = [];

    let contestant2 = {
        currentLobby: null,
        first_competitor: null,
        second_competitor: null,
        qualifier: () => {
            return [first_competitor, second_competitor]
        },
        setFirstContestant: (loby) => {
            this.first_competitor = currentLobby[0];
        },
        setSecondContestant: (lobby) => { 
            return true;
        }
    };

    // set interval
    // if lobby.lenth <= 1 , don't find prospect match
    // GAME DISPATCHER
    setInterval(() => {
        if (lobby.length >= 2) {
            const first_contestant = lobby[Math.floor(Math.random() * lobby.length)];

            const remaining_contestant = lobby.filter((lobbyUser) => {
                return lobbyUser.id != first_contestant.id;
            });

            const second_contestant = remaining_contestant.filter((contestant) => {
                const difference = Math.abs(first_contestant.mmr - contestant.mmr); //make it positive integer

                //ibig sabihin pasok sa elo
                if(difference <= 10){
                    return contestant;
                }
            });

            console.log('first_contestant', first_contestant);

            //possible na start ang game
            if(second_contestant[0]){
                //kapag pwede na, inform user using io.to([first_user, second_user]).emit('match-found', 'match found!'); 
                //stop the interval for a while
                //start to save the data from db
                //add new column para sa current_room sa users table
                //--affected tables: users, matches, match_participants
                //create match
                //once created, move the user to arena using io.to([first_user, second_user]).emit('move-to-arena', 'moving to arena...');
            }
            
            console.log('----------------------------------------------------------------');
        }
    }, 6000);

    // io.to([first_user, second_user]).emit('match-found', 'match found!');

    io.on("connection", (socket) => {
        console.log('INITIALIZED!');

        socket.emit("connection", 'connected!');

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

        socket.on("disconnect", () => {
            lobby = lobby.filter((user) => user.socketID !== socket.id);
            socket.leave("waiting-area");
            console.log('disconnected', lobby);
        });

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
            return response.data.access_token;
        } catch (error) {
            console.log('error', error);
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

})();
