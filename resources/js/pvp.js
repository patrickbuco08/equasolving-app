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

(async () => {
    const socket = io(`http://${window.location.hostname}:3000`);
    const user = await getAuthenticatedUser();

    const animation = {
            success: 'animated bounce',
            failed: 'animated headShake',
            ends: 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd'
        },
        classPatern = 'selected-1 selected-2 selected-3 selected-4';

    let answers = [],
        canAnswerEquation = true, pvpBgMusic = null;

    // validate
    if (!user || !user.room_id) return;

    //go to arena
    socket.emit('join-room', user.room_id);

    //success: already joined
    socket.on('room-joined', (data) => {
        // 
        console.log('room joined', data);
        createUserDOM(data);
        generateEquation(data.equation);

        //play music if the game is already started
        if(data.time < 90){
            console.log('play the music')
            pvpBgMusic = sfx.pvp.play();
        }
    });

    // initial countdown
    socket.on('initial-countdown', (ic) => {
        console.log(ic);
        $('.pvpOverlay').css('display', 'flex');
        $('.pvpOverlay span').text(ic - 1);
        sfx.tick.play();
        if (ic == 1) {
            $('.pvpOverlay').css('display', 'none');
            pvpBgMusic = sfx.pvp.play();
        }
    });

    //get countdown
    socket.on('countdown', (cd) => {
        if (cd <= 5) {
            sfx.tick.play();
        }
        createTimerDisplay(cd);
    });

    //get current equation
    socket.on('new-equation', (data) => {
        canAnswerEquation = true;
        answers = [];
        generateEquation(data);
        $('div.game-area').css('opacity', '1');
    });

    //update user score
    socket.on('update-score', (data, id) => {
        const userWhoGotTheAnswer = id;

        if (user.id == userWhoGotTheAnswer) {
            sfx.correct.play();
        } else {
            sfx.incorrect.play();
        }

        $(`div#player-${userWhoGotTheAnswer}-points`).addClass(`text-success ${animation.success} green`).one(animation.ends, function () {
            $(`div#player-${userWhoGotTheAnswer}-points`).removeClass(`text-success ${animation.success} green`);
        });

        console.log(data);
        createUserDOM(data);
    });

    //trigger wrong answer (for you only)
    socket.on('wrong-answer', (isCorrect) => {
        canAnswerEquation = false;
        $('div.game-area').css('opacity', '0.5');
        console.log(isCorrect);
        sfx.incorrect.play();
    });

    socket.on("finished", async (userData) => {
        console.log(userData);
        const response = await axios({
            method: 'POST',
            url: `${window.location.origin}/skeleton/win-lose-announcement`,
            data: userData
        });

        sfx.pvp.fade(1, 0, 1000, pvpBgMusic);

        let your_score = 0, enemy_score = 0;

        if(userData.player_one.id == user.id){
            your_score = userData.player_one.points;
            enemy_score = userData.player_two.points;
        }else{
            your_score = userData.player_two.points
            enemy_score = userData.player_one.points;
        }

        //draw
        if(your_score == enemy_score){
            sfx.win.play();
        }else{
            if(your_score > enemy_score){
                sfx.win.play();
            }else{
                sfx.lose.play();
            }
        }

        $('div#root').html(response.data);
    });

    //kapag may nadidisconnect na user
    socket.on('user-disconnected', (users) => {
        console.log('user disconnected');
    });

    //answer equation
    $(document).on('click', 'div.equation', function (e) {
        e.preventDefault();
        const answer = $(this).data('answer'),
        lastAnswer = answers.slice(-1)[0] ?? null,
            patternUI = $(this).children('span.circle');
        console.log(answer);

        //your previous answer is wrong
        if (!canAnswerEquation) {
            sfx.incorrect.play();
            return;
        }

        sfx.tap.play();

        if ($(this).hasClass('active')) {
            if (answer == lastAnswer) {
                console.log('equal and answer sa last element');
                answers.pop();
                $(this).removeClass('active');
                patternUI.removeClass(classPatern);
            }
        } else {
            answers.push(answer);
            patternUI.addClass(`selected-${answers.length}`);
            $(this).addClass('active');
        }

        if (answers.length == 4) {
            console.log(answers);
            socket.emit('equation-answer', user, answers);
            $('div.equation').removeClass('active');
            $('div.equation span.circle').removeClass(classPatern);
            answers = [];
        }

    });

    $('.reset').on("click", function (e) {
        e.preventDefault();
        $('div.equation').removeClass('active');
        $('div.equation span.circle').removeClass(classPatern);
        answers = [];
    });

})();
