import $ from "jquery";
import {
    modalPurchaseTheme,
    modalEquipConfirmation,
    modalInsufficientTheme,
    modalSettings,
    modalThemeEquiped,
    modalThemePurchased,
} from "./utilities/modalService";

import { equipTheme, renderShop, purchaseTheme } from "./utilities/request";

import sfx from "./sfx";

(() => {
    // modalPurchaseTheme,
    // modalEquipConfirmation,
    // modalInsufficientTheme,
    // modalSettings,
    // modalThemeEquiped,
    // modalThemePurchased,

    let backgroundID = 0, type = null, theme = '';
    const modalContent = $('section#overlay div.modal-content');

    $(document).on("click", ".theme-for-sale", function (e) {
        e.preventDefault();
        console.log(this);
        
        backgroundID = $(this).data('id'),
        theme = $(this).data('theme');
        type = null;

        console.log(theme)
        console.log('background id', backgroundID);
        sfx.tap.play();
    
        if ($(this).hasClass('locked-theme')) {
            //not owned, ask to purchase theme
            modalContent.html(modalPurchaseTheme);
            type ='modalPurchaseTheme';
        } else {
            //owned
            if (!$(this).hasClass('default')) {
                //default, ask to re equip
                modalContent.html(modalEquipConfirmation);
                type = 'modalEquipConfirmation';
            }
        }

        if(!type) return;

        $('section#overlay').show();
    });

    $(document).on("click", "button#modal-cancel", function (e) { 
        e.preventDefault();
        sfx.tap.play();
        $('section#overlay').hide();
    });

    //equip theme
    $(document).on("click", "button#equip", async function (e) { 
        e.preventDefault();
        sfx.tap.play();
        $(this).attr('disabled', true).text('Please wait...');
        await equipTheme(backgroundID);
        $('body').attr('id', theme);

        //render shop UI
        const shopUI = await renderShop();
        $('div#root').html(shopUI);

        $(this).attr('disabled', false).text('Equip');
        $('section#overlay').hide();
    });

    // purchase
    $(document).on("click", "button#purchase", async function (e) { 
        e.preventDefault();

        sfx.tap.play();
        $(this).attr('disabled', true).text('Please wait...');

        const purchaseResult = await purchaseTheme(backgroundID);

        if(purchaseResult){
            $('body').attr('id', theme);

            //render shop UI
            const shopUI = await renderShop();
            $('div#root').html(shopUI);


            $('section#overlay').hide();
        }else{
            modalContent.html(modalInsufficientTheme);
        }
            $(this).attr('disabled', false).text('Purchase');
    });

    $(document).on("click", "button#okay", function (e) { 
        e.preventDefault();
        sfx.tap.play();
        $('section#overlay').hide();
    });

})();
