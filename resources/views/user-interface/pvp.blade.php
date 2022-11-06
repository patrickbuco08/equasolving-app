@extends('layouts.app', ['title' => 'PVP'])

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"
    integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('css/pvp/style.css') }}">
@endsection

@section('content')
{{-- <section id="content-section">
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
        <input readonly type="text" class="eq-mmr" id="mmr" placeholder="210">
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
        <input readonly type="text" value="2:00" placeholder="2:00">
        <input readonly type="text" value="30" placeholder="2:00">
    </div>
    <div class="game-grid grid" id="game-grid">
        <div class="row" id="row-1">
            <span class="data" id="data-1"> </span>
            <span class="data" id="data-1"> </span>
            <span class="data" id="data-1">99 + 99 = ?</span>
            <span class="data" id="data-1"> </span>
        </div>
        <div class="row" id="row-2">
            <span class="data" id="data-2"> </span>
            <span class="data" id="data-2">99 + 99 = ?</span>
            <span class="data" id="data-2"> </span>
            <span class="data" id="data-2"> </span>
        </div>
        <div class="row" id="row-3">
            <span class="data" id="data-3"> </span>
            <span class="data" id="data-3"> </span>
            <span class="data" id="data-3"> </span>
            <span class="data" id="data-3">99 + 99 = ?</span>
        </div>
        <div class="row" id="row-4">
            <span class="data" id="data-4">99 + 99 = ?</span>
            <span class="data" id="data-4"> </span>
            <span class="data" id="data-4"> </span>
            <span class="data" id="data-4"> </span>
        </div>
    </div>
    <button class="reset-btn" id="reset">Reset</button>
</div>
</div>
</section>

<div class="eq-version flex flex-jc-c">
    <span>Version Alpha.</span>
</div> --}}
<section>
    <div class="timer">
        <span id="timer">1:30</span>
    </div>
    <div class="equation-container"></div>
    <div class="reset">
        <button>Reset</button>
    </div>
    <div class="users"></div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
    integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
</script>
<script type="module">
    (() => {
        // http://127.0.0.1:8000/pvp?room=12345
        const socket = io('http://127.0.0.1:3000');

        const user = {
            id: getParam().id ?? 1,
            name: getParam().name ?? 'Patrick Demillo Buco',
            room: getParam().room ?? '12345'
        };

        let successFX = 'animated bounce',
        failedFX = 'animated headShake',
        fxEnds = 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd',
        countdown = 60, answers = [];

        let canAnswerEquation = true;

        if(!user.room){
            alert('Check your name/room');
            return;
        }

        socket.emit('join-room', user.room);

        socket.on('room-joined', (data) => {
            createUserDOM(data);
            generateEquation(data.equation);
            console.log(data);
         });

         //get new equation
         socket.on('new-equation', (data) => { 
            canAnswerEquation = true;
            answers = [];
            generateEquation(data);
          });

          //get updated score
          socket.on('update-score', (data) => { 
            createUserDOM(data);
           });

         //get countdown
         socket.on('countdown', (cd) => {
            countdown = cd
            createTimerDisplay()
            console.log(cd)
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
            createUserDOM(users)
         })

        //answer equation
        $(document).on('click', 'div.equation', function () {
            if($(this).hasClass('active')){
                return;
            }

            //return if user cannot answer equation
            if(!canAnswerEquation){
                alert('its not your turn');
                return;
            }

            $(this).addClass('active');
            console.log($(this).data('answer'))
            answers.push($(this).data('answer'))
            // equation.setAnswer($(this).data('answer'));

            if(answers.length == 4){
                console.log(answers);
                socket.emit('equation-answer', user, answers);
                $('div.equation').removeClass('active');
                answers = []
            }
        });

        $('.reset button').click(function (e) {
            e.preventDefault();
            $('div.equation').removeClass('active');
            answers = []
        });

        function createUserDOM(users){
            let htmlDOM = '<ul>';

            for (const key in users.contestants) {
                if (Object.hasOwnProperty.call(users.contestants, key)) {
                    const user = users.contestants[key];
                    console.log(user);
                    htmlDOM += `<li>${user.name} (<span id="score-${user.id}">${user.points}</span>)</li>`;
                }
            }
            htmlDOM += `</ul>`;
            $('div.users').html(htmlDOM);
         }

         function createTimerDisplay() {
            if (countdown <= 0) {
                alert('GAME OVER')
                return;
            }

            if (countdown < 10) {
                if (countdown == 0) {
                    $('div span#timer').text(`6${countdown}`);
                    return;
                }
                $('div span#timer').text(`0${countdown}`);
                return;
            }

            $('div span#timer').text(`${countdown}`);
        }

        function generateEquation(eq) {
            let equations = eq,
                htmlDOM = '';

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

            htmlDOM += `<div class="equation" data-answer=${equation.answer} >${equation.a}${operation}${equation.b}=???</div>`;
            });
            $('div.equation-container').html(htmlDOM);
        }

        function isAnswerSorted() {
            let second_index;
            for (let first_index = 0; first_index < answers.length; first_index++) {
                second_index = first_index + 1;
                if (answers[second_index] - answers[first_index] < 0) return false;
            }
            return true;
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
