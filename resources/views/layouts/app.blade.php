<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google-signin-client_id" content="{{env('GOOGLE_APP_ID')}}">
    <title>{{ $title ?? 'EquaSolve' }}</title>
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <!-- @yield('styles') -->
</head>
<body>
    
    <!-- @yield('content') -->
    <button id="btnClassicSfx">CLassic SFX</button>
    <button id="btnButtonSfx">Button SFX</button>
    <button id="btnLoseSfx">Lose SFX</button>
    <button id="btnWinSfx">Win SFX</button>
    <button id="btnPvpSfx">Pvp SFX</button>
    <button id="btnMenuSfx">Menu SFX</button>
    <button id="btnStopSfx">Stop</button>
    <button id="btnPauseSfx">Pause</button>
    <button id="btnConPlaySfx">Continue Playing</button>
<div id="root">
  <audio id="bg_sfx">
  </audio>
<audio id="button_sfx">
</audio>
<audio id="winlose_sfx">
</audio>
</div>

    
    <!-- @yield('scripts') -->
</body>
<script>
</script>
</html>
