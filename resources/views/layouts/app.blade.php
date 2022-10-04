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
    @yield('styles')
</head>
<body>
    
    @yield('content')
    @yield('scripts')
</body>

</html>
