@extends('layouts.app', ['title' => 'Classic'])

@section('styles')
@endsection

@section('content')
<x-loader :title="$textLoader" />
@endsection

@section('scripts')
<script src="{{ asset('js/newClassic.js') }}" type="module"></script>
@endsection
