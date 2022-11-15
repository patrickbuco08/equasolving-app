<section id="content-section">
    <div class="eq-content-area">

        <div class="eq-header flex flex-jc-c">
            <div class="game-logo flex flex-jc-c">
                <div class="logo-container" id="main-logo">
                    <img src="{{ asset('images/Logo.png') }}" alt="EquaSolve-Logo">
                </div>
            </div>
        </div>

        <div class="eq-mm-container">
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h1 class="welcome-text">
                        @auth
                        Hello {{ auth()->user()->name }}
                        @endauth
                        @guest
                        Hello Anonymous
                        @endguest
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
        </div>

        <div class="main-menu-container">
            <div class="menu flex flex-vert" style="gap: 1rem">
                <div id="find-match" class="pvp-btn menu-btn flex " disabled>
                    <div class="img-container">
                        <img src="/images/Pvp Logo.png" alt="PVP-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2 id="find-match-text">Connecting...</h2>
                        <p>Play against other players and earn trophies</p>
                    </div>
                </div>
                <div id="cancel" class="classic-btn menu-btn flex" style="display: none">
                    <div class="img-container">
                        <img src="/images/Classic Mode Logo.png" alt="Classic-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2>Cancel Queue</h2>
                        <p>There are times where fear is good.</p>
                    </div>
                </div>
                <div id="render-home" class="shop-btn menu-btn flex ">
                    <div class="img-container">
                        <img src="/images/Shop logo.png" alt="Shop-logo">
                    </div>
                    <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">
                        <h2>Back</h2>
                        <p>Home....</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>

<div class="eq-version flex flex-jc-c">
    <span>Version Alpha.</span>
</div>

<script type="module">
    (async () => { 
        const origin = window.location.origin;
        const socket = io(origin);
        const welcomeText = $('.welcome-text').text();
        let isConnected = false;
    alert('hi');
        const user = async () => { 
            try {
                const response = await axios.get(`${origin}/user/check-auth`);
                console.log(response.data);
                return response.data;
            } catch (error) {
                return null;
            }
         }
         await user();
        

        socket.on("connection", (data) => { 
            console.log(data);
            user.socketID = socket.id;
            $('#find-match-text').text('Find Match');
            isConnected = true;
            console.log(user);
         });

         socket.on("match-found", (data) => {
            $('.welcome-text').text('MATCH FOUND!');
            $('div#find-match').css('display', 'none');
            $('div#cancel').css('display', 'none');

            console.log('MATCH FOUND', data);
          });

        socket.on("move-to-arena", (room, user) => { 
            $('.welcome-text').text('Moving to arena...');
            setTimeout(() => {
                window.location.href = `http://127.0.0.1:8000/pvp?id=${user.id}&name=${user.name}&room=${room}`;
            }, 3000);
            console.log('arena', data);
         })

        $(document).on('click', 'div#find-match', function (e) { 
            e.preventDefault();

            if(isConnecting){
                return;
            }

            $('div#find-match').css('display', 'none');
            $('div#cancel').css('display', 'inherit');
            $('.welcome-text').text('Finding Match...');
            socket.emit("find-match", user);
        });

        $('div#cancel').click(function (e) { 
            e.preventDefault();

            $(this).css('display', 'none');
            $('div#find-match').css('display', 'inherit');
            $('.welcome-text').text(welcomeText);
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
