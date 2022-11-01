@extends('layouts.app', ['title' => 'Find Match'])

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
    <button type="button" id="find-match">find match</button>
    <button type="button" id="cancel" style="display: none">cancel</button>

    <div id="lobby-user"></div>

</section>
@endsection

@section('scripts')
<script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
</script>
<script type="module">
    (() => {
        const socket = io('http://127.0.0.1:3000');

        const user = {
            id: getParam().id ?? 1,
            socketID: socket.id,
            name: getParam().name ?? 'Patrick Demillo Buco',
            mmr: getParam().mmr ?? 500
        };

        socket.on("connection", (data) => { 
            console.log(data);
            user.socketID = socket.id;
         });

         socket.on("match-found", (data) => { 
            console.log(data);
          });

        // const room = getParam().room;

        // if(!room){
        //     alert('Check your room')
        //     return;
        // }

        $('button#find-match').click(function (e) { 
            e.preventDefault();
            $(this).css('display', 'none');
            $('button#cancel').css('display', 'block');
            socket.emit("find-match", user);
        });

        $('button#cancel').click(function (e) { 
            e.preventDefault();
            $('button#find-match').css('display', 'block');
            $(this).css('display', 'none');
            socket.emit("cancel-find-match", user);
        });


        //kapag may nadidisconnect na user
        socket.on('user-disconnected', (users) => {
            createUserDOM(users)
        })

        $('.reset button').click(function (e) {
            e.preventDefault();
            $('div.equation').removeClass('active');
            answers = []
        });
        
        function getParam(){
            let query = window.location.search,
            parameters = new URLSearchParams(query),
            room = parameters.get('room'),
            name = parameters.get('name'),
            id = parameters.get('id'),
            mmr = parameters.get('mmr')

            return { name, room, id, mmr }
        }

    })();
</script>
@endsection