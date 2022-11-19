@extends('layouts.app', ['title' => 'PVP'])

@section('styles')

@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area">
        <div id="pvp">
            <div class="pvpOverlay" style="display: none">
                <span>READY</span>
            </div>
            <header>
                <div class="timer">
                    <div class="player one" id="player-one-name">Player #1</div>
                    <div class="countdown">1:30</div>
                    <div class="player two" id="player-two-name">Player #2</div>
                </div>
                <div class="versus-section">
                    <div class="player one"></div>
                    <div class="versus">
                        <!-- <span class="exit"></span> -->
                        <span>vs</span>
                    </div>
                    <div class="player two"></div>
                </div>
                <div class="points">
                    <div class="points-holder one"><span>1 pts</span></div>
                    <div class="points-holder two"><span>2 pts</span></div>
                </div>
            </header>
            <main>
                <div class="game-area">
                    <div class="equation equation-1 active">
                        <span class="circle selected-1"></span>
                        <span id="equation-1">999+999=???</span>
                    </div>
                    <div class="equation equation-2 active">
                        <span class="circle selected-2"></span>
                        <span id="equation-2">999+999=???</span>
                    </div>
                    <div class="equation equation-3 active">
                        <span class="circle selected-3"></span>
                        <span id="equation-3">999+999=???</span>
                    </div>
                    <div class="equation equation-4 active">
                        <span class="circle selected-4"></span>
                        <span id="equation-4">999+999=???</span>
                    </div>
                    <div class="big-square">
                    </div>
                </div>
                <div class="reset">
                    <div class="button-reset">RESET</div>
                </div>
            </main>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/pvp.js') }}" type="module"></script>
@endsection
