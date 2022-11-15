<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="google-signin-client_id" content="{{env('GOOGLE_APP_ID')}}">
    <title>{{ $title ?? 'EquaSolve' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"
        integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.2/axios.min.js"
        integrity="sha512-bHeT+z+n8rh9CKrSrbyfbINxu7gsBmSHlDCb3gUF1BjmjDzKhoKspyB71k0CIRBSjE5IVQiMMVBgCWjF60qsvA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
        integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
    </script> --}}
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/socket.io.min.js') }}"></script>

    @yield('styles')
</head>

<body id="main-default">

    <div id="root">
        @yield('content')
    </div>

    <script src="{{ asset('js/asyncFunctions.js') }}"></script>
    <script>
        // navigator
        (async () => {
            $nickNameInput = 'input[name="set-nickname"]';
            $addNickNameBtn = 'button[name="add-nickname"]';
            console.log('origin', origin);

            //validation sa pag input ng nickname
            $(document).on('keyup', $nickNameInput, function (e) {
                e.preventDefault();
                const nickname = $($nickNameInput).val();
                const disabledButton = nickname ? true : false;
                console.log(disabledButton);

                $($addNickNameBtn).attr('disabled', !disabledButton);

            });

            //submit nickname
            $(document).on('click', $addNickNameBtn, async function (e) {
                e.preventDefault();
                await createUserUsingNickName();
            });

            //render classic UI
            $(document).on('click', '#menu-btn-1', async function (e) {
                e.preventDefault();
                const classic = await renderClassic();
                $('div#root').html(classic);
            });

            //clicks PVP button
            $(document).on('click', '#menu-btn-2', async function (e) {
                e.preventDefault();
                const findMatch = await renderFindMatch();
                $('div#root').html(findMatch);
            });

            // click shop
            $(document).on('click', '#menu-btn-3', async function (e) {
                e.preventDefault();
                
                const shop = await renderShop();
                $('div#root').html(shop);
            });

            // render match history
            $(document).on('click', '#profile', async function (e) {
                e.preventDefault();
                const matchHistory = await renderMatchHistory();
                $('div#root').html(matchHistory);
            });

            //render home
            $(document).on('click', '#render-home', async function (e) {
                e.preventDefault();
                const home = await renderHome();
                $('div#root').html(home);
            });

            //logout
            $(document).on('click', 'div#logout', async function (e) {
                e.preventDefault();
                await logoutUser();
            });

        })();

    </script>
    @yield('scripts')
</body>

</html>
