@extends('layouts.app', ['title' => 'User Profile'])

@section('content')
{{-- css style here --}}

{{-- HTML here --}}
<h3>Profile</h3>
<div>
    <div>
        <label for="username">Name: </label>
        <span id="username"></span>
    </div>
    <div>
        <label for="totalmatch">Total match/es: </label>
        <span id="totalmatch"></span>
    </div>
    <div>
        <label  for="winrate">Win rate: </label>
        <span  id="winrate" ></span>
    </div>
    <div>
        <label for="mmr">MMR: </label>
        <span id="mmr" ></span>
    </div>
</div>
<script>
    $.ajax({
        type: "get",
        url: "http://127.0.0.1:8000/user/4",
        dataType: "json",
        success: function (response) {
            $("#username").html(response.name);
            $("#totalmatch").html(response.pvp_mode_details.total_matches);
            $("#winrate").html(response.pvp_mode_details.winrate);
            $("#mmr").html(response.pvp_mode_details.mmr);
        }
    });
</script>
@endsection
