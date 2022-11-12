<div id="main-default-summary">
    <div class="ms-content-area">
            <div class="eq-header flex flex-jc-c">
                <div class="game-logo flex flex-jc-c">
                    <div class="logo-container" id="classic-logo">
                        <img src="{{ asset('images/Classic Mode Logo.png') }}" alt="EquaSolve-Logo">
                    </div>
                </div>
            </div>  
            <div class="eq-title-container margin-tb-25">
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
            <div class="summary-button-container margin-tb-25 flex flex-vert flex-jc-sb">
                <button class="main-menu-btn" id="main-menu">My Score: {{ $match->score }} <br/>
                    Enemy Name: {{ $match->details->enemy->user->name}} <br/>
                    Enemy Score: {{ $match->details->enemy->score}} <br/>
                    status: {{ $match->status ? 'win' : 'lose' }} <br/>
                    date: {{$match->created_at->diffForHumans()}} 
                </button>
            </div>
            @endforeach
            <div class="summary-button-container margin-tb-25 flex flex-vert flex-jc-sb" style="background-color: 'orange">
                <button class="main-menu-btn" id="render-home">BACK</button>
            </div>
    </div>       
</div>
<script>
    (() => {
        $('div#main-default-summary').show();
})();
</script>