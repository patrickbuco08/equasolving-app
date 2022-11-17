import $ from "jquery";
import sfx from "./sfx";
import {
    createUserDOM,
    generateEquation,
    createTimerDisplay,
    getParam
} from "./utilities/pvpService";
import {
    getAuthenticatedUser
} from "./utilities/request";
import {
    io
} from "socket.io-client";

// ANIMATION IS MISSING

(async () => {
    const origin = window.location.origin;
    const socket = io(`http://${window.location.hostname}:3000`), welcomeText = $('.welcome-text').text()
    let isConnected = false, user = null;
    console.log(window.location);
    socket.on("connection", async (data) => { 
        user = await getAuthenticatedUser();
        user.socketID = socket.id;
        $('div.find-match').children('span').text('Find Match');
        isConnected = true;
        console.log('CONNECTED!');
     });

     socket.on("match-found", (roomID, versusScreen) => {
        $('div#root').html(versusScreen);

        // move to arena
        setTimeout(() => {
            window.location.href = `${origin}/pvp?room=${roomID}`;
        }, 3000);
      });

      socket.on("initial-countdown", (data) => { 
        console.log(data);
       });

    socket.on("move-to-arena", (room, user) => { 
        $('.welcome-text').text('Moving to arena...');
        setTimeout(() => {
            window.location.href = `${origin}/pvp?id=${user.id}&name=${user.name}&room=${room}`;
        }, 3000);
        console.log('arena', data);
     })

    $(document).on('click', 'div.find-match', function (e) { 
        e.preventDefault();
        
        if(!user || !isConnected){
            alert('something went wrong...');
            return;
        }

        const userData = {
            id: user.id,
            name: user.name,
            socketID: user.socketID,
            mmr: user.pvp_mode_details.mmr
        }

        $(this).css('display', 'none');
        $('div.cancel').css('display', 'inherit');
        socket.emit("find-match", userData);
    });

    $('div.cancel').click(function (e) { 
        e.preventDefault();

        $(this).css('display', 'none');
        $('div.find-match').css('display', 'inherit');
        socket.emit("cancel-find-match", user);
    });

})();
