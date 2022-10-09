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
{{-- <script src="./js/timer.js" type="module"></script> --}}
<script src="https://cdn.socket.io/3.1.3/socket.io.min.js"
    integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous">
</script>
<script type="module">
const socket = io('http://127.0.0.1:3000')
const room = getParam().room
const gameStart = getParam().start ? true : false

console.log(gameStart)

//client
socket.emit('new-user', 'patrick') //send data to server

socket.emit('join-room', 1312321, room)

if(!gameStart){
    console.log('start the game')
    socket.emit('game-start', room)
}else{
    
}


//client
//socket.on('chat-message') -> receive message.
//socket.emit('send-chat-message') -> send message

//server
//socket.on('send-chat-message') -> dito mapupunta yung sinend na message
//sa loob nyan may socket.broadcast.emit('chat-message') -> mag sesend ng message sa client

//server-room
//socket.to(room).emit('chat-message')

//receive message
socket.on('connect', () => {
    
    console.log('connected: ', socket.id)
})

socket.on('count-down', left => {
    console.log(`time left : ${left}`)
})

socket.on('message', data => {
    console.log(data)
})

socket.on('user-connected', data => {
    alert(JSON.stringify(data))
})

socket.on('user-disconnected', data => {
    alert(`disconnected: ${data}`)
})

function getParam(){
    let url_string = window.location.href;
    let url = new URL(url_string);
    return {
        room: url.searchParams.get("room"),
        start: url.searchParams.get("start")
    };
}
   
</script>
@endsection
