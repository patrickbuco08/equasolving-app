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


    socket.on("connection", async (data) => { 
        user = await getAuthenticatedUser();
        user.socketID = socket.id;
        $('.welcome-text').text('PVP Match!');
        isConnected = true;
        console.log('CONNECTED!');
     });

     socket.on("match-found", (roomID, versusScreen) => {
        console.log('match found');
        sfx.correct.play();
        console.log(versusScreen);
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

     //find match
    $(document).on('click', 'div.find-match', function (e) { 
        e.preventDefault();

        // don't allow user to find match if his account is not from google, intead redirect him to google login
        if(!$(this).hasClass('authenticated')){
            console.log('not authenticated, please login using google account');
            window.location.href = `${origin}/google-login`;
            return true;
        }

        if(!user || !isConnected){
            console.log('undefined user or not connected');
            return false;
        }

        const userData = {
            id: user.id,
            name: user.name,
            socketID: user.socketID,
            mmr: user.pvp_mode_details.mmr
        }

        $(this).css('display', 'none');
        $('div.cancel').css('display', 'inherit');
        $('.welcome-text').text('Finding Match...');

        socket.emit("find-match", userData);
    });

    $('div.cancel').on("click", function (e) { 
        e.preventDefault();

        $(this).css('display', 'none');
        $('div.find-match').css('display', 'inherit');
        $('.welcome-text').text('PVP Match!');
        
        socket.emit("cancel-find-match", user);
    });

})();
