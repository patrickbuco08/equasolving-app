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

    user.room_id = getParam().room; //pass the room id

    const animation = {
            success: 'animated bounce',
            failed: 'animated headShake',
            ends: 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd'
        },
        classPatern = 'selected-1 selected-2 selected-3 selected-4';

    let answers = [],
        canAnswerEquation = true;

    // validate
    if (!user || !user.room_id) return;

    //go to arena
    socket.emit('join-room', user.room_id);

    //success: already joined
    socket.on('room-joined', (data) => {
        sfx.pvp.play();
        createUserDOM(data);
        generateEquation(data.equation);
    });

    // initial countdown
    socket.on('initial-countdown', (ic) => {
        console.log(ic);
        $('.pvpOverlay').css('display', 'flex');
        $('.pvpOverlay span').text(ic - 1);
        sfx.tick.play();
        if (ic == 0) {
            $('.pvpOverlay').css('display', 'none');
        }
    });

    //get countdown
    socket.on('countdown', (cd) => {
        if (cd <= 10) {
            sfx.tick.play();
        }
        createTimerDisplay(cd);
    });

    //get current equation
    socket.on('new-equation', (data) => {
        canAnswerEquation = true;
        answers = [];
        generateEquation(data);
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
        console.log(isCorrect);
        sfx.incorrect.play();
    });

    socket.on("finished", async (userData) => {
        const response = await axios({
            method: 'POST',
            url: `${window.location.origin}/skeleton/win-lose-announcement`,
            data: userData
        });

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
            lastAnswer = answers.at(-1),
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
