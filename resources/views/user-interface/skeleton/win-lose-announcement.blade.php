<section id="content-section" class="content-mid">
    <div class="eq-content-area">
        <div id="win-lose">
            <main>
                <div class="container">
                    <div class="match-status">
                        @if ($isDraw)
                        <h1>DRAW</h1>
                        @else
                        <h1>{{ $player['isWinner'] ? 'WIN' : 'LOSE' }}</h1>
                        @endif
                    </div>
                    <div class="player-information">
                        <span class="player-name">{{ $player['name'] }}</span>
                        <div class="player one flex flex-ai-c flex-jc-c"><span class="span-lose">X X</span></div>
                        <div class="info mmr"><span><b>MMR: </b>{{ $player['mmr'] }}</span></div>
                        <div class="info points"><span><b>Points: </b> {{ $player['points'] }}</span></div>
                        <div class="info trophy"><span><b>NEW MMR: </b>{{ $player['updated_mmr'] }}</span></div>
                        <div class="info main-menu" id="render-home"><span><b>Menu Menu</b></span></div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>