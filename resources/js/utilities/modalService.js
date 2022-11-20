// purchase theme
const modalPurchaseTheme = () => {

    return `<div id="unlock-theme" class="unlock-theme">
    <div class="eq-mm-container">
        <div class="eq-title-container">
            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                <h3 class="welcome-text">
                    Purchase Theme?
                </h3>
            </div>
            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                <div class="square-left flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
                <div class="square-right flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-button-container flex flex-hori flex-jc-sb">
        <button class="purchase-btn" id="purchase">Purchase</button>
        <button class="cancel-btn" id="modal-cancel">Cancel</button>
    </div>
</div>`;

}

// insufficient theme
const modalInsufficientTheme = () => {
    return `<div id="error-modal" class="error-modal">
    <div class="eq-mm-container">
        <div class="eq-title-container">
            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                <h3 class="welcome-text">
                    Insufficient trophies..
                </h3>
            </div>
            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                <div class="square-left flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
                <div class="square-right flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
            </div>
        </div>
    </div>
    <button class="okay-btn" id="okay">Okay</button>
</div>`;
}

// theme purchased
const modalThemePurchased = () => {
    return `<div id="success-modal" class="success-modal">
    <div class="eq-mm-container">
        <div class="eq-title-container">
            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                <h3 class="welcome-text">
                    Theme Purchased!
                </h3>
            </div>
            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                <div class="square-left flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
                <div class="square-right flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
            </div>
        </div>
    </div>
    <button class="okay-btn" id="okay">Okay</button>
</div>`;
}

// equip theme confirmation
const modalEquipConfirmation = () => {
    return `<div id="equip-modal" class="equip-modal">
    <div class="eq-mm-container">
        <div class="eq-title-container">
            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                <h3 class="welcome-text">
                    Equip theme?
                </h3>
            </div>
            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                <div class="square-left flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
                <div class="square-right flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-button-container flex flex-hori flex-jc-sb">
        <button class="equip-btn" id="equip">Equip</button>
        <button class="cancel-btn" id="modal-cancel">Cancel</button>
    </div>
</div>`;
}

// theme equiped
const modalThemeEquiped = () => {
    return `<div id="theme-equip-modal" class="theme-equip-modal">
    <div class="eq-mm-container">
        <div class="eq-title-container">
            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                <h3 class="welcome-text">
                    Theme Equiped!
                </h3>
            </div>
            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                <div class="square-left flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
                <div class="square-right flex flex-vert flex-jc-sb">
                    <span class="us"></span>
                    <span class="us"></span>
                </div>
            </div>
        </div>
    </div>
    <button class="okay-btn" id="okay">Okay</button>
</div>`;
}

// settings
const modalSettings = () => {

    const BgMusicSwitch = localStorage.getItem("equasolve_music_fx") == "true" ? true : false;
    const sfxSwitch = localStorage.getItem("equasolve_sfx") == "true" ? true : false;

    return `
    <div id="settings-fx" class="settings">
        <div class="eq-mm-container">
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h3 class="welcome-text">
                        Settings
                    </h3>
                </div>
                <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                    <div class="square-left flex flex-vert flex-jc-sb">
                        <span class="us"></span>
                        <span class="us"></span>
                    </div>
                    <div class="square-right flex flex-vert flex-jc-sb">
                        <span class="us"></span>
                        <span class="us"></span>
                    </div>
                </div>
                <div class="flex flex-hori flex-ai-c flex-jc-se">
                    <h3 style="width:40px">Music:</h3>
                    <span class="header-btn" id="musicOnOff">
                        <img id="musicImg" style="width: 35px;height: 35px"
                            src="/images/music-${BgMusicSwitch ? 'on' : 'off'}.png" alt="BGMusic">
                    </span>
                </div>
                <div class="flex flex-hori flex-ai-c flex-jc-se">
                    <h3 style="width:40px">SFX:</h3>
                    <span class="header-btn" id="SFXOnOff">
                        <img id="sfxImg" style="width: 35px;height: 35px"
                            src="/images/music-${sfxSwitch ? 'on' : 'off'}.png" alt="BGMusic">
                    </span>
                </div>
            </div>
        </div>
        <button class="okay-btn" id="classic-tutorial">Classic Tutorial</button>
        <button class="okay-btn" id="pvp-tutorial" style="margin-top: .5rem">PVP Tutorial</button>
        <button class="okay-btn" id="modal-cancel" style="margin-top: .5rem">Close</button>
    </div>
`;
}

const modalClassicTutorial = () => {
    return `
    <div id="settings-classic-tutorial" class="settings">
        <div class="eq-mm-container">
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h3 class="welcome-text">
                        Classic Tutorial
                    </h3>
                </div>
                <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                    <div class="square-left flex flex-vert flex-jc-sb">
                        <span class="us"></span>
                        <span class="us"></span>
                    </div>
                    <div class="square-right flex flex-vert flex-jc-sb">
                        <span class="us"></span>
                        <span class="us"></span>
                    </div>
                </div>
                <div class="flex flex-hori flex-ai-c flex-jc-se" style="margin-top: 1rem">
                    <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c"
                        style="padding: .5rem; text-align: center">
                        <h4 class="welcome-text" style="text">
                            Classic mode is as timer based continuous gameplay.
                            Each player starts with 20s on the clock. Player solves the equations, while
                            referring to the answer player should tap each item in an increasing manner.
                            Every correct answer adds 5s on the clock while every mistake deducts 3s.
                            Player can try unlimited times until the clock is exhausted.
                            Every 30s worth of gameplay rewards 1 trophy. <br /> <br/>

                            Levels of difficulty:
                            Level 1 -5 : Single digit, Additions and Subtractrions equation only
                            Level 6-10: Two digits, Additions and Subtractrions equation
                            Level 11 and above: Two digits per equation (4 Basic Arithmetic Equations
                            involved)
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <button class="okay-btn" id="done-tutorial">OK</button>
    </div>
`;
}

const modalPvpTutorial = () => { 
    return `
    <div id="settings-pvp-tutorial" class="settings">
        <div class="eq-mm-container">
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h3 class="welcome-text">
                        PVP Tutorial
                    </h3>
                </div>
                <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                    <div class="square-left flex flex-vert flex-jc-sb">
                        <span class="us"></span>
                        <span class="us"></span>
                    </div>
                    <div class="square-right flex flex-vert flex-jc-sb">
                        <span class="us"></span>
                        <span class="us"></span>
                    </div>
                </div>
                <div class="flex flex-hori flex-ai-c flex-jc-se" style="margin-top: 1rem">
                    <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c"
                        style="padding: .5rem; text-align: center">
                        <h4 class="welcome-text" style="text">
                            In PVP mode player is randomly matched to a player within the same MMR
                            range. Each player solves the equations, while referring to the answer
                            player should tap each item in an increasing manner. <br/><br/>
                            If a player gets the answer correctly the score is automatically awarded.<br/><br/>
                            If a player gets the answer wrong the other player still gets to try and get
                            the point.<br/><br/>
                            If both player gets the answer wrong no one gets the point.<br/><br/>
                            Battle time limit is 1m and 30s. Winning player gets the additional MMR
                            while the Losing player gets a deduction.
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <button class="okay-btn" id="done-tutorial">OK</button>
    </div>

`;
 }

export {
    modalPurchaseTheme,
    modalEquipConfirmation,
    modalInsufficientTheme,
    modalSettings,
    modalThemeEquiped,
    modalThemePurchased,
    modalClassicTutorial,
    modalPvpTutorial
}
