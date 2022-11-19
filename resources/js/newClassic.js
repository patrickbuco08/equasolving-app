import {
    equation,
    timer,
    gameTimer
} from "./utilities/classicService";
import {
    Howler
} from "howler";
import $ from "jquery";
import sfx from "./sfx";

import {
    renderClassicSkeleton,
    sleep
} from "./utilities/request";

(async () => {

    await sleep(1000); //load for 2 seconds

    const classicUI = await renderClassicSkeleton(); //get the classic UI

    $('div#root').html(classicUI); //render classic UI

    const BgMusicSwitch = localStorage.getItem("equasolve_music_fx") == "true" ? true : false;
    const sfxSwitch = localStorage.getItem("equasolve_sfx") == "true" ? true : false;

    const animation = {
            success: 'animated bounce',
            failed: 'animated headShake',
            ends: 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd'
        },
        classPatern = 'selected-1 selected-2 selected-3 selected-4';

    setTimeout(() => {

        if (BgMusicSwitch) {
            sfx.classic.play();
        }

    }, 200);


    timer.init(); // init timer
    equation.generateDOM(); // generate equation

    //answer equation
    $(document).on('click', 'div.equation', function (e) {
        e.preventDefault();

        const answer = $(this).data('answer'),
            lastAnswer = equation.answers.at(-1),
            patternUI = $(this).children('span.circle');

        console.log(answer);
        sfx.tap.play();

        //check if the equation you tap is already selected
        if ($(this).hasClass('active')) {
            //if the answer you tap is your last answer, then unselect
            if (answer == lastAnswer) {
                equation.answers.pop();
                $(this).removeClass('active');
                patternUI.removeClass(classPatern);
            }
        } else {
            //push your answer
            equation.setAnswer(answer);
            patternUI.addClass(`selected-${equation.answers.length}`);
            $(this).addClass('active');
        }

        //equations are already selected
        if (equation.answers.length == 4) {

            console.log('your answers', equation.answers);

            //correct answer
            if (equation.isAnswerSorted()) {

                sfx.correct.play();
                timer.addTime(5);
                equation.generateDOM();
                onAnswerEquationAnimation(true);

            } else {
                // incorrect
                sfx.incorrect.play();
                timer.deductTime(3);
                equation.answers = []
                $('div.equation').removeClass('active');
                $('div.equation span.circle').removeClass(classPatern);
                onAnswerEquationAnimation();

            }

        }

    });

    //show settings
    $('#settings').on("click", function (e) {
        e.preventDefault();
        timer.pause();
    });

    // hide settings
    $('#close').on("click", function (e) {
        e.preventDefault();
        $("#settings-modal").hide();
        timer.continue();
    });

    //show exit confirmation modal
    $('#exit-game').on("click", function (e) {
        e.preventDefault();

        $("#exit-modal").show();
        timer.pause();
    });

    //cancel exit modal
    $('#cancel').on("click", function (e) {
        e.preventDefault();
        $("#exit-modal").hide();
        timer.continue();
    });

    // exit the game
    $('#exit').on("click", function (e) {
        e.preventDefault();
        $("#exit-modal").hide();
        timer.quit();
    });

    // toggle background music
    $("#musicOnOff").on('click', function () {

        if (window.location.pathname != "/classic") return;
        console.log('trigger settings on classic');

        const musicFXisOn = localStorage.getItem("equasolve_music_fx") === "true" ? true : false;

        localStorage.setItem("equasolve_music_fx", musicFXisOn ? "false" : "true");
        $("#musicImg").attr('src', `/images/music-${!musicFXisOn ? 'on' : 'off'}.png`);

        if (musicFXisOn) {
            console.log('we pause')
            sfx.classic.pause();
        } else {
            console.log('we play')
            sfx.classic.play();
        }

    });

    // toggle sound FX
    $("#SFXOnOff").on('click', function (e) {

        if (window.location.pathname != "/classic") return;
        console.log('trigger settings on classic');

        const isSfxOn = () => {
            return localStorage.getItem("equasolve_sfx") === "true";
        }
        localStorage.setItem("equasolve_sfx", isSfxOn() ? "false" : "true");
        $("#sfxImg").attr('src', `/images/music-${isSfxOn() ? 'on' : 'off'}.png`);
    });

    //reset selected equation
    $('div.button-reset').on("click", function (e) {
        e.preventDefault();

        // reset the equation UI
        $('div.equation').removeClass('active');
        $('div.equation span.circle').removeClass(classPatern);

        equation.answers = [];
    });


    // for correct/wrong answer animation
    function onAnswerEquationAnimation(status = false) {

        let logoAnimationClass = `text-danger ${animation.failed} red`,
            timerAnimationClass = `text-danger red`;

        //if status is true, triggered correct answer animation
        if (status) {
            logoAnimationClass = `text-success ${animation.success} green`;
            timerAnimationClass = `text-success green`;
        }

        // reset the equation UI
        $('div.equation').removeClass('active');
        $('div.equation span.circle').removeClass(classPatern);

        // add answer animation in logo
        $('div#classic-logo').addClass(logoAnimationClass).one(animation.ends, function () {
            $('div#classic-logo').removeClass(logoAnimationClass);
        });

        // add answer animation in countdown
        $('div#countdown-timer-container').addClass(timerAnimationClass);

        setTimeout(() => {
            $('div#countdown-timer-container').removeClass(timerAnimationClass);
        }, 1000);

        //not working
        // $('span#minus-time').addClass(`minus-time-absolute move-up-animation`);

        // setTimeout(() => {
        //     $('span#minus-time').removeClass(`minus-time-absolute move-up-animation`);
        // }, 1500);
    }

})();
