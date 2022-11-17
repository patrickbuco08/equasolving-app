@extends('layouts.app', ['title' => 'Classic'])

@section('styles')
<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
@endsection

@section('content')
<section id="content-section" class="start d-none">
    <div class="eq-content-area vh-100">
            <div class="eq-header flex flex-jc-sb">
                <div class="left-side flex flex-vert flex-ai-fs flex-jc-sb">
                    <button class="header-btn" id="settings">
                        <img src="{{ asset('images/Settings.png') }}" alt="settings">
                    </button>
                    <button class="header-btn hide" id="profile">
                        <img src="{{ asset('images/User Profile.png') }}" alt="profile">
                    </button>
                    <button class="header-btn" id="exit-game">
                        <img src="{{ asset('images/Exit.png') }}" alt="exit-game">
                    </button>
                </div>
                <div class="game-logo flex flex-jc-c">
                    <div class="logo-container" id="classic-logo">
                        <img src="{{ asset('images/Classic Mode Logo.png') }}" alt="EquaSolve-Logo">
                    </div>
                </div>
                <div class="right-side flex flex-vert flex-ai-fe flex-jc-sb">
                    <div class="input-container hide">
                        <span class="mmr">MMR:</span>
                        <input readonly type="text" class="eq-mmr" id="mmr" placeholder= "210">
                        <span class="mmr-2">MMR: </span>
                    </div>
                    <div class="input-container">
                        <span class="trophy">Trophy:</span>
                        <input readonly type="text" class="eq-trophy" id="trophy" placeholder="1200">
                        <div class="img-container"></div>
                    </div>
                </div>     
            </div>  
            
            <div class="game-area flex flex-jc-sb flex-vert " id="game-area">
                <div class="timer-container flex flex-hori flex-jc-sb">
                    <div class="relative">
                        <span id="add-time"></span>
                        <span id="minus-time"></span>
                        <input id="timer" readonly type="text">
                    </div>
                    <div class="relative">
                        <span id="add-trophy"></span>
                        <input id="trophy" readonly type="text">
                    </div>
                </div>
                <div class="level"><span id="level"></span></div>
                <div class="game-grid grid" id="game-grid">
                    
                    <div class="row" id="row-1"> 
                        <span class = "data" id="data-1"> </span>
                        <span class = "data" id="data-1"> </span>
                        <span class = "data" id="data-1">99 + 99 = ?</span>
                        <span class = "data" id="data-1"> </span>
                    </div>
                    <div class="row" id="row-2">
                        <span class = "data" id="data-2"> </span>
                        <span class = "data" id="data-2">99 + 99 = ?</span>
                        <span class = "data" id="data-2"> </span>
                        <span class = "data" id="data-2"> </span>
                    </div>
                    <div class="row" id="row-3">
                        <span class = "data" id="data-3"> </span>
                        <span class = "data" id="data-3"> </span>
                        <span class = "data" id="data-3"> </span>
                        <span class = "data" id="data-3">99 + 99 = ?</span>
                    </div>
                    <div class="row" id="row-4">
                        <span class = "data" id="data-4">99 + 99 = ?</span>
                        <span class = "data" id="data-4"> </span>
                        <span class = "data" id="data-4"> </span>
                        <span class = "data" id="data-4"> </span>
                    </div>
                </div>
                    <button class="reset-btn" id="reset">Reset</button>
                </div>
            </div>


</section>
<div id="main-default-summary" class="maxwidth-500 margin-auto">
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
                            Classic Mode Summary:
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
                <span class="main-menu-btn" id="summary-level">Level: </span>
                <span class="play-again-btn" id="summary-trophy">Trophy: </span>
            </div>
            <div class="summary-button-container margin-tb-25 flex flex-vert flex-jc-sb">
                <button class="main-menu-btn" id="main-menu">Main Menu</button>
                <button class="play-again-btn" id="play-again">Play Again</button>
            </div>
    </div>     
</div>
<div id="main-default-loading" class="d-none maxwidth-500 margin-auto">
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
                        <h1 class="welcome-text" id="loading">Classic Mode Loading<span></span></div>
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
</div>

<div id="exit-modal" class="modal">
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

  </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/classic.js') }}" type="module"></script>
@endsection
