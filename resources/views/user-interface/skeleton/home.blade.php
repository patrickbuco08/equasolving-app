<section id="content-section">
    <div class="eq-content-area">

        <div class="eq-header flex flex-jc-sb">
            <div class="left-side flex flex-vert flex-ai-fs flex-jc-sb">
                <button type="button" class="header-btn" id="settings">
                    <img src="{{ asset('images/Settings.png') }}" alt="settings">
                </button>
                <button type="button" class="header-btn" id="profile">
                    <img src="{{ asset('images/User Profile.png') }}" alt="profile">
                </button>
            </div>
            <div class="game-logo flex flex-jc-c">
                <div class="logo-container" id="main-logo">
                    <img src="{{ asset('images/Logo.png') }}" alt="EquaSolve-Logo">
                </div>
            </div>
            {{-- {{auth()->user()->classicModeDetails}} --}}
            <div class="right-side flex flex-vert flex-ai-fe flex-jc-sb">
                @auth
                <div class="input-container">
                    <span class="mmr">MMR:</span>
                    <input readonly type="text" class="eq-mmr" id="mmr"
                        placeholder="{{auth()->user()->pvpModeDetails->mmr}}">
                    <span class="mmr-2">MMR:</span>
                </div>
                <div class="input-container">
                    <span class="trophy">Trophy:</span>
                    <input readonly type="text" class="eq-trophy" id="trophy"
                        placeholder="{{auth()->user()->classicModeDetails->trophies}}">
                    <div class="img-container"></div>
                </div>
                @endauth
                @guest
                <div class="input-container">
                    <span class="mmr">MMR:</span>
                    <input readonly type="text" class="eq-mmr" id="mmr" placeholder="0">
                    <span class="mmr-2">MMR:</span>
                </div>
                <div class="input-container">
                    <span class="trophy">Trophy:</span>
                    <input readonly type="text" class="eq-trophy" id="trophy" placeholder="0">
                    <div class="img-container"></div>
                </div>
                @endguest
            </div>
        </div>

        <div class="eq-mm-container">
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h1 class="welcome-text">
                        @auth
                        Hello {{ Str::of(auth()->user()->name)->explode(' ')[0] }}
                        @endauth
                        @guest
                        Hello Anonymous
                        @endguest
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
        </div>

        <div class="main-menu-container">
            <div class="menu flex flex-vert flex-jc-sb">
                <div id="menu-btn-1" class="classic-btn menu-btn flex ">
                    <div class="img-container">
                        <img src="{{ asset('images/Classic Mode Logo.png') }}" alt="Classic-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2>Classic</h2>
                        <p>This mode will determine your speed and solving skills.</p>
                    </div>
                </div>
                <div id="menu-btn-2" class="pvp-btn menu-btn flex ">
                    <div class="img-container">
                        <img src="{{ asset('images/Pvp Logo.png') }}" alt="PVP-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2>PVP</h2>
                        <p>Play against other players and earn trophies</p>
                    </div>
                </div>
                <div id="menu-btn-3" class="shop-btn menu-btn flex ">
                    <div class="img-container">
                        <img src="{{ asset('images/Shop logo.png') }}" alt="Shop-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2>Shop</h2>
                        <p>Exchange trophies for skins and effects.</p>
                    </div>
                </div>
                @auth
                <div id="logout" class="shop-btn menu-btn flex ">
                    <div class="img-container">
                        <img src="{{ asset('images/Shop logo.png') }}" alt="Shop-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2 id="logout-text">Logout</h2>
                        <p>is the hardest button to click.</p>
                    </div>
                </div>
                @endauth
            </div>
        </div>

    </div>
</section>

<div class="eq-version flex flex-jc-c">
    <span>Version Alpha.</span>
</div>