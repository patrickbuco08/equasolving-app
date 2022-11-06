@extends('layouts.app', ['title' => 'Classic'])

@section('styles')
<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
@endsection

@section('content')
<section id="content-section" class="start d-none">
    <div class="eq-content-area">
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
<div id="main-default-loading" class="d-none">
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
<div id="footer" class="eq-version flex flex-jc-c d-none">
        <span>Version Alpha.</span>
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
<script type="module">
    import {equation, timer, gameTimer} from '/js/classic/utils.js'
    (() => {
        let successFX = 'animated bounce', failedFX = 'animated headShake', fxEnds = 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd';
        setTimeout(() => {
            $('section#content-section').removeClass('d-none');
            $('div#main-default-loading').removeClass('d-none');
            $('div#footer').removeClass('d-none');
            }, 500);

        $('body').addClass("fade-in");
        
        $('div#main-default-summary').hide();
        $('.eq-content-area').hide();
        $('#main-default-loading').show();
        $('body#main-default').addClass('flex-jc-c-imp');
        
        

        //initialize timer

        timer.init();
        gameTimer.init();
        equation.generateDOM();
        let i = 0;
        if($("#content-section").hasClass("start")){
            timer.pause();
            timer.loading();
        }
        $(document).on('click', 'span.data', function () {
            
            if($(this).hasClass('active') && $(this).hasClass(''+i-1+'')){
                i--;
                $('span.data.'+''+i).removeClass('active');
                $('span.data').removeClass(''+i+'');
                equation.answers.splice(i);
                return
            }
            else if($(this).hasClass('active') || $(this).hasClass('0 1 2 3')){
                return
            }
            $(this).addClass('active');
            $(this).addClass(''+i+'');
            equation.setAnswer($(this).data('answer'))
            i++;
            if(equation.answers.length == 4){
                if(equation.isAnswerSorted()){
                    $('input#timer').addClass(`text-success ${successFX} green`).one(fxEnds, function(){
                        $('input#timer').removeClass(`text-success ${successFX} green`);
                    });
                    $('span#add-time').addClass(`add-time-absolute move-up-animation`);
                        setTimeout(() => {
                    $('span#add-time').removeClass(`add-time-absolute move-up-animation`);
                    }, 1500);
                    timer.addTime(5);
                    equation.generateDOM()
                    i = 0;
                }else{
                    $('input#timer').addClass(`text-danger ${failedFX} red`).one(fxEnds, function(){
                        $('input#timer').removeClass(`text-danger ${failedFX} red`);
                        $('span.data').removeClass('active');
                    });
                    $('span#minus-time').addClass(`minus-time-absolute move-up-animation`);
                        setTimeout(() => {
                    $('span#minus-time').removeClass(`minus-time-absolute move-up-animation`);
                    }, 1500);
                    timer.deductTime(3);
                    equation.answers = []
                    $('span.data').removeClass('0 1 2 3');
                    i = 0;
                    
                } 
            }
        });

        $('#reset').click(function (e) { 
            e.preventDefault();
            $('span.data').removeClass('active');
            $('span.data').removeClass('0 1 2 3');
            equation.answers = []
            i = 0;
        });
        $('#exit-game').click(function (e) { 
            e.preventDefault();
            timer.pause();
            $("#exit-modal").show();
        });              
        $('#cancel').click(function (e) { 
            e.preventDefault();
            $("#exit-modal").hide();
            timer.continue();
        }); 
        $('#exit').click(function (e) { 
            e.preventDefault();
            $("#exit-modal").hide();
            timer.quit();
        }); 
        const renderMainMenu = async () => {
            const origin = window.location.origin;
            const response = await axios.get(`${origin}/skeleton/home`);
            $('div#root').html(response.data);
        }

        $('#main-menu').click(function (e) {
            e.preventDefault();
            //renderMainMenu();
            const origin = window.location.origin;
            window.location.href = `${origin}`;
        });
        $('#play-again').click(function (e) {
            e.preventDefault();
            $('div#root').animate({opacity: 0}, 500);
            setTimeout(() => {
                const origin = window.location.origin;
                window.location.href = `${origin}/classic`;
            }, 1000);
        });

    })();
</script>
@endsection
