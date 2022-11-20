<section id="content-section">
    <div class="eq-content-area">

        <div class="eq-header flex flex-jc-sb">
            <div class="left-side flex flex-vert flex-ai-fs flex-jc-sb">
                <button class="header-btn" id="settings">
                    <img src="/images/Settings.png" alt="settings">
                </button>
                <button class="header-btn hide" id="profile">
                    <img src="/images/User Profile.png" alt="profile">
                </button>
                <button class="header-btn" id="exit-game">
                    <img src="/images/Exit.png" alt="exit-game">
                </button>
            </div>
            <div class="game-logo flex flex-jc-c">
                <div class="logo-container" id="classic-logo">
                    <img src="/images/Classic Mode Logo.png" alt="EquaSolve-Logo">
                </div>
            </div>
            <div class="right-side flex flex-vert flex-ai-fe flex-jc-sb">
                <div class="input-container hide">
                    <span class="mmr">MMR:</span>
                    <input readonly type="text" class="eq-mmr" id="mmr" placeholder="210">
                    <span class="mmr-2">MMR: </span>
                </div>
                <div class="input-container">
                    <span class="trophy">Trophy:</span>
                    <input readonly type="text" class="eq-trophy" id="trophy" placeholder="{{auth()->user()->classicModeDetails->trophies}}">
                    <div class="img-container"></div>
                </div>
            </div>
        </div>

        <div id="classic">
            <header class="classic-timer">
                <div class="classic-points">
                    <div class="holder " id="countdown-timer-container"><span id="countdown-timer">0:00</span></div>
                    <div class="holder level"><span>Level 0</span></div>
                    <div class="holder "><span id="trophies-holder">0 pt</span></div>
                </div>
            </header>
            <main>
                <div class="game-area"></div>
                <div class="reset">
                    <div class="button-reset">RESET</div>
                </div>
            </main>
        </div>
    </div>
</section>

{{-- <div id="exit-modal" class="modal">
    <div class="modal-content">
      <div class="eq-mm-container">
                  <div class="eq-title-container">
                      <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                          <h1 class="welcome-text">
                              Do you want to exit game?
                          </h1>
                      </div>
                      <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                          <div class="square-left-exit flex flex-vert flex-jc-sb">
                              <span class="us"></span>
                              <span class="us"></span>
                          </div>
                          <div class="square-right-exit flex flex-vert flex-jc-sb">
                              <span class="us"></span>
                              <span class="us"></span>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="exit-button-container flex flex-hori flex-jc-sb">
                  <button class="exit-btn" id="exit">Exit</button>
                  <button class="cancel-btn" id="cancel">Cancel</button>
              </div>
  
      </div>
  
  </div> --}}
