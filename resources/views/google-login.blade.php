@extends('layouts.app', ['title' => 'Google Login'])

@section('styles')
<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
@endsection

@section('content')
<div class="g-signin2" data-onsuccess="onSignIn"></div>
@endsection

@section('scripts')
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
    function onSignIn(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        console.log('Name: ' + profile.getName());
        console.log('Image URL: ' + profile.getImageUrl());
        console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
    
</script>
@endsection
