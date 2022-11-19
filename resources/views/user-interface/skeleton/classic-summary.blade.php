<section id="content-section" class="content-mid" >
    <div class="eq-content-area">
    <div id="main-default-summary" style="display: block;" >
        <main>
        <div class="logo"></div>
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h1 class="welcome-text">
                        Classic Mode Summary
                    </h1>
                </div>
                <div class="square flex flex-hori flex-jc-sb">
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
                <div class="summary-span-container flex flex-hori flex-jc-sb">
                    <span class="main-menu-btn" id="summary-level">Level: {{$level}}</span>
                    <span class="play-again-btn" id="summary-trophy">{{ Str::plural('Trophy', $trophies) }}: {{$trophies}}</span>
                </div>
                <div class="summary-button-container margin-tb-25 flex flex-vert flex-jc-sb">
                    <button class="main-menu-btn" id="render-home">Main Menu</button>
                    <button class="play-again-btn" id="menu-btn-1">Play Again</button>
                </div>  
            </div>   
        </main> 
    </div>
</section>