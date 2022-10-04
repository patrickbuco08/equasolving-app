@extends('layouts.app', ['title' => 'Settings'])

@section('content')
{{-- css style here --}}

{{-- HTML here --}}
<h1>Settings</h1>
<div>
    <label for="btnBgOnOff">Background Music:</label><button id="btnBgOnOff">ON</button>
    <br />
    <label for="btnSfxOnOff">Background SFX: </label><button id="btnSfxOnOff">ON</button>
</div>
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
@endsection