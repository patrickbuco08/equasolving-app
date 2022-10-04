@extends('layouts.app', ['title' => 'User Profile'])

@section('content')
{{-- css style here --}}

{{-- HTML here --}}
<h3>Profile</h3>
<div>
    <div>
        <label for="username">Name: </label>
        <span id="username">sample</span>
    </div>
    <div>
        <label for="totalmatch">Total match/es: </label>
        <span id="totalmatch">No match found.</span>
    </div>
    <div>
        <label for="winrate">Win rate: </label>
        <span id="winrate">No match found.</span>
    </div>
</div>
<script>
</script>
@endsection
