@extends('layouts.app', ['title' => 'Classic'])

@section('styles')
<link rel="stylesheet" href="{{ asset('css/classic/style.css') }}">
@endsection

@section('content')
<x-loader :title="$textLoader" />
@endsection

@section('scripts')
<script src="{{ asset('js/newClassic.js') }}" type="module"></script>
@endsection
