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
                        <span>Connecting...</span>
                    </div>
                    <div class="button cancel" style="display: none">
                        <span>Cancel Queue</span>
                    </div>
                    <div class="tips">
                        <span><b>Tips: </b> There are times where fear is good.</span>
                    </div>
                </div>
                <div class="button menu" id="render-home">
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
<script type="module">
    (async () => {
        const origin = window.location.origin;
        const socket = io(`http://${window.location.hostname}:3000`), welcomeText = $('.welcome-text').text()
        let isConnected = false, user = null;
        console.log(window.location);
        socket.on("connection", async (data) => { 
            user = await getAuthenticatedUser();
            user.socketID = socket.id;
            $('div.find-match').children('span').text('Find Match');
            isConnected = true;
            console.log('CONNECTED!');
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
