 import $ from "jquery";
 import sfx from "./sfx";
 import {
     renderShop,
     createUserUsingNickname,
     renderMatchHistory,
     renderHome,
     renderHomeSkeleton,
     renderClassic,
     renderFindMatch,
     logoutUser,
     updateNickName
 } from "./utilities/request";

 import {
     modalSettings,
     modalClassicTutorial,
     modalPvpTutorial,
     logOutConfirmation,
     setNickName
 } from "./utilities/modalService";

 // navigator
 (async () => {
     console.log('init navigator');
     let menuBgMusic = null;

     const BgMusicSwitch = () => {
        return localStorage.getItem("equasolve_music_fx") == "true";
     }

     const isSfxOn = () => {
         return localStorage.getItem("equasolve_sfx") === "true";
     }

     // on bg and sfx if not set 
     if (localStorage.getItem("equasolve_music_fx") === null) {
         localStorage.setItem("equasolve_music_fx", "true");
     }

     if (localStorage.getItem("equasolve_sfx") === null) {
         localStorage.setItem("equasolve_sfx", "true");
     }

     setTimeout(() => {
         // play only if page is on the landing page
         if (window.location.pathname == "/" || window.location.pathname == "/find-match") {
             console.log('play');
             if (BgMusicSwitch()) {
                 menuBgMusic = sfx.menu.play();
             }
         }
     }, 100);

     $(document).on('click', '#musicOnOff', function () {

         if (window.location.pathname != "/") return;
         console.log('trigger settings on landing page');

         const musicFXisOn = localStorage.getItem("equasolve_music_fx") === "true" ? true : false;
         localStorage.setItem("equasolve_music_fx", musicFXisOn ? "false" : "true");
         $("#musicImg").attr('src', `/images/music-${!musicFXisOn ? 'on' : 'off'}.png`);

         if (musicFXisOn) {
             sfx.menu.pause();
         } else {
             sfx.menu.play();
         }

     });

     $(document).on('click', '#SFXOnOff', function (e) {

         if (window.location.pathname != "/") return;
         let equasolve_sfx = null;

         //if naka on
         if (isSfxOn()) {
             //then, off
             equasolve_sfx = "false";
             $("#sfxImg").attr('src', `/images/music-off.png`);
             sfx.tap.volume(0);

         } else {
             //on the sfx
             equasolve_sfx = "true";
             $("#sfxImg").attr('src', `/images/music-on.png`);
             sfx.tap.volume(1);
         }

         localStorage.setItem("equasolve_sfx", equasolve_sfx);
         sfx.tap.play();

     });

     //  fx settings
     $(document).on("click", '#settings', function (e) {
         e.preventDefault();
         sfx.tap.play();

         console.log('check it trigerred');
         const modalContent = $('section#overlay div.modal-content');

         modalContent.html(modalSettings);

         $('section#overlay').show();

     });

     //  read classic tutorial
     $(document).on("click", "button#classic-tutorial", function (e) {
         e.preventDefault();

         sfx.tap.play();
         const modalContent = $('section#overlay div.modal-content');
         modalContent.html(modalClassicTutorial);

     });

     // read pvp tutorial
     $(document).on("click", "button#pvp-tutorial", function (e) {
         e.preventDefault();

         sfx.tap.play();
         const modalContent = $('section#overlay div.modal-content');
         modalContent.html(modalPvpTutorial);

     });

     // done reading tutorials
     $(document).on("click", "button#done-tutorial", function (e) {
         e.preventDefault();

         sfx.tap.play();
         const modalContent = $('section#overlay div.modal-content');
         modalContent.html(modalSettings);

     });

    //  creating nickname

     //validation sa pag input ng nickname
     $(document).on('keyup', 'input[name="set-nickname"]', function (e) {
         e.preventDefault();
         const nickname = $('input[name="set-nickname"]').val();
         const disabledButton = nickname ? true : false;
         console.log(disabledButton);

         sfx.tap.play();

         $('button[name="add-nickname"]').attr('disabled', !disabledButton);
         $('button[name="update-nickname"]').attr('disabled', !disabledButton);

     });

     //submit nickname
     $(document).on('click', 'button[name="add-nickname"]', async function (e) {
         e.preventDefault();
         alert('hi');
         sfx.tap.play();
         await createUserUsingNickname();
     });


    //  for updating nicknme
    $(document).on('click', 'button[name="update-nickname"]', async function (e) {
        e.preventDefault();
        sfx.tap.play();
        await updateNickName();
    });

     //render classic UI
     $(document).on('click', '#menu-btn-1', function (e) {
         e.preventDefault();
         sfx.tap.play();

         sfx.tap.on("end", async () => {
             sfx.menu.fade(1, 0, 1000, menuBgMusic);
             const classic = await renderClassic();

             $('div#root').html(classic);
         });
     });

     //clicks PVP button
     $(document).on('click', '#menu-btn-2', async function (e) {
         e.preventDefault();

         $(this).on('click', false);
         sfx.tap.play();

         if ($(this).hasClass('reconnect')) {
             const roomID = $(this).data('room');
             window.location.href = `${origin}/pvp?room=${roomID}`
             return;
         }

         sfx.tap.on("end", async () => {
             const findMatch = await renderFindMatch();
             $('div#root').html(findMatch);
         });

     });

     // click shop
     $(document).on('click', '#menu-btn-3', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         const shop = await renderShop();
         $('div#root').html(shop);
     });

     // render match history
     $(document).on('click', '#profile', async function (e) {
         e.preventDefault();
         sfx.tap.volume(localStorage.getItem("equasolve_sfx") === "true" ? 1 : 0);
         sfx.tap.play();
         const matchHistory = await renderMatchHistory();
         $('div#root').html(matchHistory);
     });

     //render home
     $(document).on('click', '#render-home', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         sfx.tap.on("end", async () => {
             const home = await renderHome();
             $('div#root').html(home);
         });

     });

     //render home
     $(document).on('click', '#render-home-skeleton', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         const home = await renderHomeSkeleton();
         $('div#root').html(home);

     });

     //  reconnect
     $(document).on("click", "div#reconnect", function (e) {
         e.preventDefault();
         alert('hello');

     });

     $(document).on("click", "h1#set-nickname", function (e) { 
        e.preventDefault();
        sfx.tap.play();
        const modalContent = $('section#overlay div.modal-content');
        const renderSetNickname = setNickName($(this).text());
        modalContent.html(renderSetNickname);
        $('section#overlay').show();
     });

     //logout confirmation
     $(document).on("click", "div#logout-confirmation", function (e) { 
        e.preventDefault();

        sfx.tap.play();
        const modalContent = $('section#overlay div.modal-content');
        modalContent.html(logOutConfirmation);
        $('section#overlay').show();
     });

     //logout
     $(document).on('click', 'button#logout', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         sfx.tap.on("end", async () => {
             await logoutUser();
         });
     });

 })();
