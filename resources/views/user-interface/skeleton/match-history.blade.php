<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
<div id="main-default-summary" style="display: block">
    <div class="ms-content-area">
            <div class="eq-header flex flex-jc-fs width-100 maxwidth-400 margin-auto">
                <div class="game-logo flex flex-jc-c">
                    <div class="logo-container" id="classic-logo">
                        <img src="{{ asset('images/Logo.png') }}" alt="EquaSolve-Logo">
                    </div>
                </div>
                <div class="summary-button-container flex width-90">
                    <div class="profile-container">
                        <div class="flex flex-jc-c profile-design">
                            <span>{{$user->name}}</span>
                        </div>
                        <hr />
                        <div class="flex-vert flex gap-5 info-design">
                            <div class="flex flex-hori gap-5">
                                <span>Win Rate:</span>
                                <span class="span-val">{{$user->pvpModeDetails->winrate}}%</span>
                            </div>
                            <div class="flex flex-hori gap-5">
                                <span>MMR:</span>
                                <span class="span-val">{{$user->pvpModeDetails->mmr}}</span>
                            </div>
                            <div class="flex flex-hori gap-5">
                                <span>Matched Played:</span>
                                <span class="span-val">{{$user->pvpModeDetails->total_matches}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-vert gap-5 profile-buttons">
                    @auth
                    <div id="logout-confirmation" class="shop-btn menu-btn flex ">
                        <button class="header-btn">
                            <img src="{{ asset('images/Exit.png') }}" alt="Logout">
                        </button>
                    </div>
                    @endauth
                    <button class="header-btn height-60px" id="render-home-skeleton">
                        <span>Menu</span>
                    </button>
                </div>
            </div>  
            <div class="eq-title-container margin-tb-25 maxwidth-400">
                    <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                        <h1 class="welcome-text">
                            Match History 
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
            @foreach ($matches as $match)
            <div class="history-container margin-tb-10 flex flex-vert flex-jc-c">
                <div class="flex flex-hori flex-jc-se history-details gap-5 ">
                    <div class="game-logo flex flex-jc-c">
                        <div class="logo-container" id="classic-logo">
                            <img src="{{ asset('images/PVP logo 2.png') }}" alt="EquaSolve-Logo">
                        </div>
                    </div>
                    <div class="flex flex-vert gap-5 width-100">
                        <div class="flex flex-hori flex-jc-sb">
                            @if($match->status == true)
                                <span id="status" class="c-green">Win</span>
                            @elseif($match->score == $match->details->enemy->score)
                            <span id="status" class="c-yellow">Draw</span>
                            @else
                                <span id="status" class="c-red">Lose</span>
                            @endif
                            <span id="history-time">{{$match->created_at->diffForHumans()}} </span>
                        </div>
                        <div class="flex flex-hori flex-jc-sb">
                            <div class="flex flex-vert flex-ai-c">
                                <span id="score">My Score: </span>
                                <span>{{ $match->score }}</span>
                            </div>
                            <div class="flex flex-vert flex-ai-c">
                                <span id="score">Enemy Score: </span>
                                <span>{{ $match->details->enemy->score}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            @endforeach
    </div>       
</div>
<script>
    (() => {
        // $('div#main-default-summary').show();
})();
</script>