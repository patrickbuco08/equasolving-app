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
     logoutUser
 } from "./utilities/request";

 import {
     Howler
 } from "howler";

 import { modalSettings, modalClassicTutorial, modalPvpTutorial } from "./utilities/modalService";

 // navigator
 (async () => {
     console.log('init navigator');
     let menuBgMusic = null;
     const BgMusicSwitch = localStorage.getItem("equasolve_music_fx") == "true" ? true : false;
     const isSfxOn = () => {
        return localStorage.getItem("equasolve_sfx") === "true";
    }

     setTimeout(() => {
         // play only if page is on the landing page
         if (window.location.pathname == "/" || window.location.pathname == "/find-match") {
             console.log('play');
             if (BgMusicSwitch) {
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
         console.log('trigger settings on landing page');

         console.log(isSfxOn());
         
         localStorage.setItem("equasolve_sfx", isSfxOn() ? "false" : "true");
         $("#sfxImg").attr('src', `/images/music-${isSfxOn() ? 'on' : 'off'}.png`);
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

     //validation sa pag input ng nickname
     $(document).on('keyup', 'input[name="set-nickname"]', function (e) {
         e.preventDefault();
         const nickname = $('input[name="set-nickname"]').val();
         const disabledButton = nickname ? true : false;
         console.log(disabledButton);

         sfx.tap.play();

         $('button[name="add-nickname"]').attr('disabled', !disabledButton);

     });

     //submit nickname
     $(document).on('click', 'button[name="add-nickname"]', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         await createUserUsingNickname();
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

         if($(this).hasClass('reconnect')){
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

     //logout
     $(document).on('click', 'div#logout', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         sfx.tap.on("end", async () => {
             await logoutUser();
         });
     });

 })();
