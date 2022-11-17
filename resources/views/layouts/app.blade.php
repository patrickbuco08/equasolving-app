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

    <div id="settings-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close">&times;</span>
          <div class="eq-mm-container">
            <div class="eq-header flex flex-jc-sb">
                <div class="modal-header flex flex-vert flex-ai-c flex-jc-c">
                    <span class="header-btn white" id="settings">
                        Settings
                    </span>
                    <div class="flex flex-hori flex-ai-c flex-jc-sb">
                        <h4>Music:</h4>
                    <span class="header-btn" id="musicOnOff">
                        <img id="musicImg" src="{{ asset('images/music-on.png') }}" alt="BGMusic">
                    </span>
                    </div>
                    <div class="flex flex-hori flex-ai-c flex-jc-sb">
                        <h4>SFX:</h4>
                    <span class="header-btn" id="SFXOnOff">
                        <img id="sfxImg" src="{{ asset('images/music-on.png') }}" alt="BGMusic">
                    </span>
                    </div>
                </div>
            </div>
          </div>  
        </div>
    </div>

    {{-- <script src="{{ asset('js/asyncFunctions.js') }}"></script> --}}
    <script src="{{ asset('js/navigator.js') }}"></script>
    <script>

    </script>
    @yield('scripts')
</body>

</html>
