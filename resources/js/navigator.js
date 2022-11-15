 import $ from "jquery";
 import sfx from "./sfx";
 import { renderShop, renderMatchHistory, renderHome, renderClassic, renderFindMatch, logoutUser } from "./utilities/request";

 // navigator
 (async () => {
    console.log('init navigator');

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
         await createUserUsingNickName();
     });

     //render classic UI
     $(document).on('click', '#menu-btn-1', async function (e) {
         e.preventDefault();
         const classic = await renderClassic();
         $('div#root').html(classic);
     });

     //clicks PVP button
     $(document).on('click', '#menu-btn-2', async function (e) {
         e.preventDefault();
         const findMatch = await renderFindMatch();
         $('div#root').html(findMatch);
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
         const home = await renderHome();
         $('div#root').html(home);
     });

     //logout
     $(document).on('click', 'div#logout', async function (e) {
         e.preventDefault();
         await logoutUser();
     });

 })();
