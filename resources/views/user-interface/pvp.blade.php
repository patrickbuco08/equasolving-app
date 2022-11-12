@extends('layouts.app', ['title' => 'PVP'])

@section('styles')

@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area vh-100">
        <div id="pvp">
            <!-- <div class="pvpOverlay">
                <span>READY</span>
            </div> -->
            <header>
                <div class="timer">
                    <div class="player one" id="player-one-name">Player #1</div>
                    <div class="countdown">x:xx</div>
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
                    <div class="points-holder one" id="fuck">x</div>
                    <div class="points-holder two">x</div>
                </div>
            </header>
            <main>
                <div class="game-area">
                    <div class="equation equation-1" data-answer="6">
                        <span class="circle"></span>
                        <span id="equation-1">1+5=???</span>
                    </div>
                    <div class="equation equation-2" data-answer="11">
                        <span class="circle"></span>
                        <span id="equation-2">4+7=???</span>
                    </div>
                    <div class="equation equation-3" data-answer="10">
                        <span class="circle"></span>
                        <span id="equation-3">5+5=???</span>
                    </div>
                    <div class="equation equation-4" data-answer="3">
                        <span class="circle"></span>
                        <span id="equation-4">1+2=???</span>
                    </div>
                </div>
                <div class="reset">
                    <div class="button-reset">RESET</div>
                </div>
            </main>
            <footer>
                <p>Version Alpha.</p>
            </footer>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
    integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
</script>
<script type="module">
    (async() => {
        const socket = io('http://127.0.0.1:3000');
        const user = await getAuthenticatedUser();
        const classPatern = 'selected-1 selected-2 selected-3 selected-4';

        // MAGSASAVE KA NA NG DATA SA DATABASE
        //GAWA KA REQUEST PARA SA LOSE AND WIN

        let successFX = 'animated bounce',
        failedFX = 'animated headShake',
        fxEnds = 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd',
        answers = [], canAnswerEquation = true, minutes = 1, seconds = 30;


        user.room_id = getParam().room;

        socket.emit('join-room', user.room_id);

        //kapag naka join na
        socket.on('room-joined', (data) => {
            createUserDOM(data);
            generateEquation(data.equation);
         });

         //get new equation
         socket.on('new-equation', (data) => { 
            canAnswerEquation = true;
            answers = [];
            generateEquation(data);
          });

          //get updated score
          socket.on('update-score', (data, id) => {
            const userWhoGotTheAnswer = id;

            $(`div#player-${userWhoGotTheAnswer}-points`).addClass(`text-success ${successFX} green`).one(fxEnds, function(){
                        $(`div#player-${userWhoGotTheAnswer}-points`).removeClass(`text-success ${successFX} green`);
                    });

            console.log('TAMA YUNG SAGOT');
            console.log(data);
            createUserDOM(data);
           });

        //    initial countdown
           socket.on('initial-countdown', (ic) => { 
            console.log(ic);
           })

         //get countdown
         socket.on('countdown', (cd) => {
            const newSeconds = cd;

            seconds = newSeconds % 60;
            minutes = Math.floor(newSeconds / 60);
            createTimerDisplay();
            console.log(`sec: ${seconds} | min: ${minutes}`);
          })

        //trigger wrong answer
        socket.on('wrong-answer', (answer) => { 
            if(!answer.correct){
                canAnswerEquation = false;
                alert('wrong');
            }
         });

        //kapag may nadidisconnect na user
        socket.on('user-disconnected', (users) => {
            // createUserDOM(users)
            console.log('user disconnected');
         });

        //answer equation
        $(document).on('click', 'div.equation', function (e) {
                e.preventDefault();
                const answer = $(this).data('answer'), lastElement = answers.at(-1), patternUI = $(this).children('span.circle');
                console.log(answer);

                //return if user cannot answer equation
                if(!canAnswerEquation){
                    alert('its not your turn');
                    return;
                }

                if ($(this).hasClass('active')) {
                    if (answer == lastElement) {
                        console.log('equal and answer sa last element');
                        answers.pop();
                        $(this).removeClass('active');
                        patternUI.removeClass(classPatern);
                    }
                } else {
                    answers.push(answer);
                    patternUI.addClass(`selected-${answers.length}`)
                    $(this).addClass('active');
                }

                if (answers.length == 4) {
                    console.log(answers);
                    socket.emit('equation-answer', user, answers);
                    $('div.equation').removeClass('active');
                    $('div.equation span.circle').removeClass(classPatern);
                    answers = [];
                }

            });

        $('.reset').click(function (e) {
            e.preventDefault();
            $('div.equation').removeClass('active');
            $('div.equation span.circle').removeClass(classPatern);
            answers = [];
        });

        function createUserDOM(users){
            const contestants = [];
            

            for (const key in users.contestants) {
                if (Object.hasOwnProperty.call(users.contestants, key)) {
                    const user = users.contestants[key];
                    contestants.push(user);
                }
            }
            const player_one = contestants[0];
            const player_two = contestants[1];

            $('div#player-one-name').html(player_one.name);
            $('div#player-two-name').html(player_two.name);

            $('div.points-holder.one').attr('id', `player-${player_one.id}-points`).html(player_one.points > 1 ? `${player_one.points} points` : `${player_one.points} point`);
            $('div.points-holder.two').attr('id', `player-${player_two.id}-points`).html(player_two.points > 1 ? `${player_two.points} points` : `${player_two.points} point`);
         }

         function createTimerDisplay() {
            if (seconds < 10) {
            if (seconds == 0 && minutes > 0) {
                $('div.countdown').html(`${minutes}: 0${seconds}`);
                setTimeout(() => {
                    $('div.countdown').html(`${minutes}: ${seconds}`);
                }, 1000);
                return;
            }
            $('div.countdown').html(`${minutes}: 0${seconds}`);
            return;
        }

        $('div.countdown').html(`${minutes}: ${seconds}`);
        }

        function generateEquation(eq) {
            let equations = eq,
                htmlDOM = '', index = 1;


            equations.forEach(equation => {
                let operation = '';

                switch (equation.operation) {
                    case 'addition':
                        operation = '+';
                        break;
                    case 'subtraction':
                        operation = '-';
                        break;
                    case 'multiplication':
                        operation = 'x';
                        break;
                    case 'division':
                        operation = '/';
                        break;
            }

            // htmlDOM += `<div class="equation" data-answer=${equation.answer} >${equation.a}${operation}${equation.b}=???</div>`;
            htmlDOM += `<div class="equation equation-${index}" data-answer=${equation.answer}>
                        <span class="circle"></span>
                        <span id="equation-1">${equation.a}${operation}${equation.b}=???</span>
                    </div>`;
            index++;
            });

            $('div.game-area').html(htmlDOM);
        }
        
        function getParam(){
            let query = window.location.search,
            parameters = new URLSearchParams(query),
            id = parameters.get('id'),
            name = parameters.get('name'),
            room = parameters.get('room')

            return { id, name, room };
        }

    })();
</script>
{{-- <script src="{{ asset('js/pvp/pvp.js') }}" type="module"></script> --}}
@endsection
