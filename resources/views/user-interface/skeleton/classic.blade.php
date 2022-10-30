
<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">

<section>
    <div class="timer">
        <span id="timer">1:30</span>
    </div>
    <div class="equation-container"></div>
    <div class="reset">
        <button>Reset</button>
    </div>
        <button id="back">back</button>
</section>

<script type="module">
    import {equation, timer} from '/js/classic/utils.js'
    (() => {

        let successFX = 'animated bounce', failedFX = 'animated headShake', fxEnds = 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd';

        //initialize timer
        timer.init();
        equation.generateDOM()

        $(document).on('click', 'div.equation', function () { 
            if($(this).hasClass('active')){
                return
            }
            $(this).addClass('active');
            console.log($(this).data('answer'))
            equation.setAnswer($(this).data('answer'))

            if(equation.answers.length == 4){
                if(equation.isAnswerSorted()){
                    $('span#timer').addClass(`text-success ${successFX}`).one(fxEnds, function(){
                        $('span#timer').removeClass(`text-success ${successFX}`);
                    });
                    timer.addTime(3);
                    equation.generateDOM()
                }else{
                    $('span#timer').addClass(`text-danger ${failedFX}`).one(fxEnds, function(){
                        $('span#timer').removeClass(`text-danger ${failedFX}`);
                        $('div.equation').removeClass('active');
                    });
                    timer.deductTime(3);
                    equation.answers = []
                    
                }
            }
        });

        $('.reset button').click(function (e) { 
            e.preventDefault();
            $('div.equation').removeClass('active');
            equation.answers = []
        });     
        
        $('button#back').click(function (e) { 
            e.preventDefault();
            $('div#root').html('hi');
            // turn off interval
        });

    })();
</script>
