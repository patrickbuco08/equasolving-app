<section id="content-section">
    <div class="eq-content-area vh-100">
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
                        <div class="player one"></div>
                        <div class="info mmr"><b>MMR: </b> {{ $player['mmr'] }}</div>
                        <div class="info points"><b>POINTS: </b> {{ $player['points'] }}</div>
                        <div class="info mmr"><b>NEW MMR: </b> {{ $player['updated_mmr'] }}</div>
                    </div>
                </div>
                <div class="menu" id="render-home">
                    <span>MENU</span>
                </div>
            </main>
            <footer>
                <p>Version Alpha.</p>
            </footer>
        </div>
    </div>
</section>