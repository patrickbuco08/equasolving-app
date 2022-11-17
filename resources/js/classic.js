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

(() => {
    let successFX = 'animated bounce',
        failedFX = 'animated headShake',
        fxEnds = 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd';

    const BgMusicSwitch = localStorage.getItem("equasolve_music_fx") == "true" ? true : false;
    const sfxSwitch = localStorage.getItem("equasolve_sfx") == "true" ? true : false;

    setTimeout(() => {
        $('section#content-section').removeClass('d-none');
        $('div#main-default-loading').removeClass('d-none');
        $('div#footer').removeClass('d-none');
    }, 500);

    $('body').addClass("fade-in");

    $('div#main-default-summary').hide();
    $('.eq-content-area').hide();
    $('#main-default-loading').show();
    $('body#main-default').addClass('flex-jc-c-imp');

    setTimeout(() => {
        $("#musicImg").attr('src', `/images/music-${BgMusicSwitch ? 'on' : 'off'}.png`);
        $("#sfxImg").attr('src', `/images/music-${sfxSwitch ? 'on' : 'off'}.png`);

        console.log(BgMusicSwitch)
        if (BgMusicSwitch) {
            sfx.classic.play(); //palitan mo ng sfx.classic.play();
        }

    }, 100);


    //initialize timer

    timer.init();
    gameTimer.init();
    equation.generateDOM();
    let i = 0;
    const sequence = ['first', 'second', 'third', 'fourth'];
    if ($("#content-section").hasClass("start")) {
        timer.pause();
        timer.loading();
    }
    $(document).on('click', 'span.data', function () {

        if ($(this).hasClass('active') && $(this).hasClass('' + i - 1 + '')) {
            i--;
            $('span.data.' + '' + i).removeClass('active');
            $('span.data').removeClass('' + i + '');
            $('span.data').removeClass('' + sequence[i] + '');
            equation.answers.splice(i);
            return
        } else if ($(this).hasClass('active') || $(this).hasClass('0 1 2 3') || $(this).hasClass('first second third fourth')) {
            return
        }
        $(this).addClass('active');
        $(this).addClass('' + i + '');
        $(this).addClass('' + sequence[i] + '');
        sfx.tap.play();
        equation.setAnswer($(this).data('answer'))
        console.log(equation.answers);
        i++;
        if (equation.answers.length == 4) {
            if (equation.isAnswerSorted()) {
                $('input#timer').addClass(`text-success green`);
                setTimeout(() => {
                    $('input#timer').removeClass(`text-success green`);
                }, 1000);
                $('span#add-time').addClass(`add-time-absolute move-up-animation`);
                setTimeout(() => {
                    $('span#add-time').removeClass(`add-time-absolute move-up-animation`);
                }, 1500);
                $('div#classic-logo').addClass(`text-success ${successFX} green`).one(fxEnds, function () {
                    $('div#classic-logo').removeClass(`text-success ${successFX} green`);
                });
                timer.addTime(5);
                equation.generateDOM()
                i = 0;
                sfx.correct.play();
            } else {
                $('div#classic-logo').addClass(`text-danger ${failedFX} red`).one(fxEnds, function () {
                    $('div#classic-logo').removeClass(`text-danger ${failedFX} red`);
                });
                $('input#timer').addClass(`text-danger red`);
                setTimeout(() => {
                    $('input#timer').removeClass(`text-danger red`);
                    $('span.data').removeClass('active');
                    $('span.data').removeClass('first second third fourth');
                }, 1000);
                $('span#minus-time').addClass(`minus-time-absolute move-up-animation`);
                setTimeout(() => {
                    $('span#minus-time').removeClass(`minus-time-absolute move-up-animation`);
                }, 1500);
                timer.deductTime(3);
                equation.answers = []
                $('span.data').removeClass('0 1 2 3');
                i = 0;
                sfx.incorrect.play();
            }
        }
    });

    $('#reset').click(function (e) {
        e.preventDefault();
        $('span.data').removeClass('active');
        $('span.data').removeClass('0 1 2 3');
        $('span.data').removeClass('first second third fourth');
        equation.answers = []
        i = 0;
    });
    $('#exit-game').click(function (e) {
        e.preventDefault();
        timer.pause();
        $("#exit-modal").show();
    });
    $('#settings').click(function (e) {
        e.preventDefault();
        timer.pause();
        $("#settings-modal").show();
    });
    $('#cancel').click(function (e) {
        e.preventDefault();
        $("#exit-modal").hide();
        timer.continue();
    });
    $('#close').click(function (e) {
        e.preventDefault();
        $("#settings-modal").hide();
        timer.continue();
    });
    $('#exit').click(function (e) {
        e.preventDefault();
        $("#exit-modal").hide();
        timer.quit();
    });

    $("#musicOnOff").on('click', function () {
        const musicFXisOn = localStorage.getItem("equasolve_music_fx") === "true" ? true : false;

        localStorage.setItem("equasolve_music_fx", musicFXisOn ? "false" : "true");
        $("#musicImg").attr('src', `/images/music-${!musicFXisOn ? 'on' : 'off'}.png`);

        if (musicFXisOn) {
            console.log('we pause')
            sfx.menu.pause();
        } else {
            console.log('we play')
            sfx.menu.play();
        }

    });

    $("#SFXOnOff").on('click', function (e) {

        const isSfxOn = () => {
            return localStorage.getItem("equasolve_sfx") === "true";
        }
        localStorage.setItem("equasolve_sfx", isSfxOn() ? "false" : "true");
        Howler.mute(!musicFXisOn());
        $("#sfxImg").attr('src', `/images/music-${musicFXisOn() ? 'on' : 'off'}.png`);

        localStorage.getItem("equasolve_sfx")
        // var bgMusic = $('#bg_sfx');
        // if(bgMusic[0].volume == 1.0)
        //{
        //  bgMusic[0].volume = 0;
        //   $("#sfxImg").removeAttr("src");
        //   $("#sfxImg").attr('src', '{{ asset('/images/music-off.png') }}');
        //}
        //else 
        //{
        //bgMusic[0].volume = 1
        //$("#SFXOnOff img").src="{{ asset('images/music-on.png') }}";
        //}
    });

    const renderMainMenu = async () => {
        const origin = window.location.origin;
        const response = await axios.get(`${origin}/skeleton/home`);
        $('div#root').html(response.data);
    }

    $('#main-menu').click(function (e) {
        e.preventDefault();
        //renderMainMenu();
        const origin = window.location.origin;
        window.location.href = `${origin}`;
    });
    $('#play-again').click(function (e) {
        e.preventDefault();
        $('div#root').animate({
            opacity: 0
        }, 500);
        setTimeout(() => {
            const origin = window.location.origin;
            window.location.href = `${origin}/classic`;
        }, 1000);
    });

})();
