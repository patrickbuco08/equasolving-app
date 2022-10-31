@extends('layouts.app', ['title' => 'Classic'])

@section('styles')
<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
@endsection

@section('content')
<section>
    <div class="menu-container">
        <div class="menu">
            <button id="pause">pause</button>
        </div>
        <div class="menu">
            <button id="continue">continue</button>
        </div>
        <div class="menu">
            <button id="quit">quit</button>
        </div>
    </div>
    <div class="level">
        <span id="level">Level: 1</span>
    </div>
    <div class="timer">
        <span id="timer"></span>
    </div>
    <div class="equation-container"></div>
    <div class="reset">
        <button>Reset</button>
    </div>
        <button>back</button>
</section>
@endsection

@section('scripts')
<script type="module">
    import {equation, timer, gameTimer} from '/js/classic/utils.js'
    (() => {

        let successFX = 'animated bounce', failedFX = 'animated headShake', fxEnds = 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd';

        //initialize timer
        timer.init();
        gameTimer.init();
        equation.generateDOM();
        let i = 0;
        $(document).on('click', 'div.equation', function () {
            
            if($(this).hasClass('active') && $(this).hasClass(''+i-1+'')){
                i--;
                $('div.equation.'+''+i).removeClass('active');
                $('div.equation').removeClass(''+i+'');
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
                    $('span#timer').addClass(`text-success ${successFX}`).one(fxEnds, function(){
                        $('span#timer').removeClass(`text-success ${successFX}`);
                    });
                    timer.addTime(5);
                    equation.generateDOM()
                    i = 0;
                }else{
                    $('span#timer').addClass(`text-danger ${failedFX}`).one(fxEnds, function(){
                        $('span#timer').removeClass(`text-danger ${failedFX}`);
                        $('div.equation').removeClass('active');
                    });
                    timer.deductTime(3);
                    equation.answers = []
                    $('div.equation').removeClass('0 1 2 3');
                    i = 0;
                    
                } 
            }
        });

        $('.reset button').click(function (e) { 
            e.preventDefault();
            $('div.equation').removeClass('active');
            $('div.equation').removeClass('0 1 2 3');
            equation.answers = []
            i = 0;
        });         
        $('.menu #pause').click(function (e) { 
            e.preventDefault();
            timer.pause();
        });   
        $('.menu #continue').click(function (e) { 
            e.preventDefault();
            timer.continue();
        }); 
        $('.menu #quit').click(function (e) { 
            e.preventDefault();
            timer.quit();
        }); 
    })();
</script>
@endsection
