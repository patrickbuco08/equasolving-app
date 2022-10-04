@extends('layouts.app', ['title' => 'PVP'])

@section('styles')
{{-- CSS Here --}}
@endsection

@section('content')
{{-- HTML here --}}
<p>PvP</p>

<div class="timer"></div>
<button id="add-time">trigger correct answer</button>
<button id="deduct-time">trigger wrong answer</button>

@endsection

@section('scripts')
<script src="./js/timer.js" type="module"></script>
@endsection
