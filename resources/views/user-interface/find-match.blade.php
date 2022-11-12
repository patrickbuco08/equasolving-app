@extends('layouts.app', ['title' => 'Find Match'])

@section('styles')
{{-- css here --}}
@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area vh-100">
        <div id="find-match">
            <main>
                <div class="content">
                    <div class="logo"></div>
                    <div class="button find-match">
                        <span>Find Match</span>
                    </div>
                    <div class="button cancel" style="display: none">
                        <span>Cancel Queue</span>
                    </div>
                    <div class="tips">
                        <span><b>Tips: </b> There are times where fear is good.</span>
                    </div>
                </div>
                <div class="button menu">
                    <span>MENU</span>
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
    (async () => {
        const origin = window.location.origin;
        const socket = io('http://127.0.0.1:3000'), welcomeText = $('.welcome-text').text()
        let isConnected = false, user = null;

        socket.on("connection", async (data) => { 
            user = await getAuthenticatedUser();
            user.socketID = socket.id;
            $('#find-match-text').text('Find Match');
            isConnected = true;
            console.log(user);
         });


         socket.on("match-found", (roomID, versusScreen) => {
            $('div#root').html(versusScreen);

            // move to arena
            setTimeout(() => {
                window.location.href = `${origin}/pvp?room=${roomID}`;
            }, 3000);
          });

          socket.on("initial-countdown", (data) => { 
            console.log(data);
           });

        socket.on("move-to-arena", (room, user) => { 
            $('.welcome-text').text('Moving to arena...');
            setTimeout(() => {
                window.location.href = `${origin}/pvp?id=${user.id}&name=${user.name}&room=${room}`;
            }, 3000);
            console.log('arena', data);
         })

        $(document).on('click', 'div.find-match', function (e) { 
            e.preventDefault();
            
            if(!user || !isConnected){
                alert('something went wrong...');
                return;
            }

            const userData = {
                id: user.id,
                name: user.name,
                socketID: user.socketID,
                mmr: user.pvp_mode_details.mmr
            }

            $(this).css('display', 'none');
            $('div.cancel').css('display', 'inherit');
            socket.emit("find-match", userData);
        });

        $('div.cancel').click(function (e) { 
            e.preventDefault();

            $(this).css('display', 'none');
            $('div.find-match').css('display', 'inherit');
            socket.emit("cancel-find-match", user);
        });

    })();
</script>
@endsection
