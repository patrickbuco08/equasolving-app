<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'EquaSolve' }}</title>
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>
<body>
    @yield('content')
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
</body>
<script>
  $(document).ready(function(){
    function bgSfxPlay(obj, src){
      obj[0].src = src; 
      obj.animate({volume: 1}, 500, 'swing', function() {
        obj[0].play();
      });
      obj.attr("loop","true");
      obj.attr("autoplay","true");
    }
    function bgSfxStop(obj){
      obj.animate({volume: 0}, 1000, 'swing', function() {
        // really stop music
        obj[0].pause(); // Stop playing
        obj[0].currentTime = 0;
        obj.attr("loop","false");
      obj.attr("autoplay","false");
      });
    }

    function bgSfxPause(obj){
      obj.animate({volume: 0}, function() {
        // really stop music
        obj[0].pause(); // Stop playing
      });
      
    }
    function bgSfxConPlaying(obj){
      obj.animate({volume: 1}, function() {
        // really stop music
        obj[0].play(); // Stop playing
      });
      
    }
    $("#btnClassicSfx").on('click',function(e){
    var obj = $('#bg_sfx');
    var src = '{{ asset('sfx/classic_sfx.mp3') }}'; 
    bgSfxPlay(obj, src);
    });
    
    $("#btnButtonSfx").click(function(){
    var obj = $('#button_sfx'); 
    obj[0].src = '{{ asset('sfx/button_sfx.mp3') }}'; 
    obj[0].play();
    });

    $("#btnLoseSfx").click(function(){
      var obj = $('#winlose_sfx');
      obj[0].src = '{{ asset('sfx/lose_sfx.mp3') }}'; 
      obj[0].play();
    });

    $("#btnWinSfx").click(function(){
      var obj = $('#winlose_sfx');
      
      obj[0].src = '{{ asset('sfx/win_sfx.mp3') }}'; 
      obj[0].play();
    });

    $("#btnPvpSfx").click(function(){
      var obj = $('#bg_sfx');
      var src = '{{ asset('sfx/pvp_sfx.mp3') }}'; 
    bgSfxPlay(obj, src);
    });

    $("#btnMenuSfx").click(function(){
      var obj = $('#bg_sfx');
      var src = '{{ asset('sfx/menu_sfx.mp3') }}'; 
      if(obj.is("[src]")){
        bgSfxStop(obj);
      }
      bgSfxPlay(obj, src);
    });

    $("#btnStopSfx").click(function(){
      var obj = $('#bg_sfx');
      if(obj.is("[src]")){
      bgSfxStop(obj);
      }
    });

    $("#btnPauseSfx").click(function(){
      var obj = $('#bg_sfx');
      if(obj.is("[src]")){
        bgSfxPause(obj);
      }
    });
    $("#btnConPlaySfx").click(function(){
      var obj = $('#bg_sfx');
      if(obj.is("[src]")){
        bgSfxConPlaying(obj);
      }
    });
  
});
</script>
</html>
