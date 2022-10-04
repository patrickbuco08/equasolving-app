@extends('layouts.app', ['title' => 'Settings'])

@section('styles')
    {{-- CSS Here --}}
@endsection

@section('content')
{{-- HTML here --}}
<h1>Settings</h1>
<div>
    <label for="btnBgOnOff">Background Music:</label><button id="btnBgOnOff">ON</button>
    <br />
    <label for="btnSfxOnOff">Background SFX: </label><button id="btnSfxOnOff">ON</button>
</div>

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

@endsection
@section('scripts')
    {{-- Scripts Here --}}
<script>
$(document).ready(function(){
    
    $("#btnBgOnOff").on('click',function(e){
    var bgMusic = $('#bg_sfx');
    if(bgMusic[0].volume == 1.0)
    {
        bgMusic[0].volume = 0;
        $("#btnBgOnOff").text("OFF");
    }
    else 
    {
        bgMusic[0].volume = 1
        $("#btnBgOnOff").text("ON");
    }
    });
    
    $("#btnSfxOnOff").on('click', function(){
    var sfxBtn = $('#button_sfx'); 
    var sfxWL = $('#winlose_sfx');
    if(sfxBtn[0].volume == 1.0)
    {
        sfxBtn[0].volume = 0;
        sfxWL[0].volume = 0;
        $("#btnSfxOnOff").text("OFF");
    }
    else 
    {
        sfxBtn[0].volume = 1;
        sfxWL[0].volume = 1;
        $("#btnSfxOnOff").text("ON");
    }
    });


  
});
</script>
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
@endsection
