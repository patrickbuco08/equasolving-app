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

 // navigator
 (async () => {
     console.log('init navigator');
     let menuBgMusic = null;
     const BgMusicSwitch = localStorage.getItem("equasolve_music_fx") == "true" ? true : false;
     const sfxSwitch = localStorage.getItem("equasolve_sfx") == "true" ? true : false;

     setTimeout(() => {
         // play only if page is on the landing page
         if (window.location.pathname == "/" || window.location.pathname == "/find-match") {
             console.log('play');
             if (BgMusicSwitch) {
                 menuBgMusic = sfx.menu.play();
             }
         }
     }, 100);

     $("#musicImg").attr('src', `/images/music-${BgMusicSwitch ? 'on' : 'off'}.png`);
     $("#sfxImg").attr('src', `/images/music-${sfxSwitch ? 'on' : 'off'}.png`);

     $("#musicOnOff").on('click', function () {

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

     $("#SFXOnOff").on('click', function (e) {

         if (window.location.pathname != "/") return;
         console.log('trigger settings on landing page');

         const isSfxOn = () => {
             return localStorage.getItem("equasolve_sfx") === "true";
         }
         localStorage.setItem("equasolve_sfx", isSfxOn() ? "false" : "true");
         Howler.mute(!musicFXisOn());
         $("#sfxImg").attr('src', `/images/music-${musicFXisOn() ? 'on' : 'off'}.png`);
     });

     $(document).on("click", '#settings', function (e) {
         e.preventDefault();
         $("#settings-modal").show();
     });

     $(document).on('click', '#close', function (e) {
         e.preventDefault();
         $("#settings-modal").hide();
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
         sfx.tap.on("end", async () => {
             const findMatch = await renderFindMatch();
             $('div#root').html(findMatch);
         });

     });

     // click shop
     $(document).on('click', '#menu-btn-3', async function (e) {
         e.preventDefault();

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

     //logout
     $(document).on('click', 'div#logout', async function (e) {
         e.preventDefault();
         sfx.tap.play();
         sfx.tap.on("end", async () => {
             await logoutUser();
         });
     });

 })();
