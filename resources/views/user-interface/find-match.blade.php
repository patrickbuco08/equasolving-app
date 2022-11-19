@extends('layouts.app', ['title' => 'Find Match'])

@section('styles')
{{-- css here --}}
@endsection

@section('content')
<section id="content-section" class="content-mid">
    <div class="eq-content-area">
        <div id="find-match">
            <main>
                <div class="content">
                    <div class="logo"></div>
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h1 class="welcome-text">
                                    Connecting...
                                </h1>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb">
                                <div class="square-left flex flex-vert flex-jc-sb">
                                    <span class="us"></span>
                                    <span class="us"></span>
                                </div>
                                <div class="square-right flex flex-vert flex-jc-sb">
                                    <span class="us"></span>
                                    <span class="us"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-container flex flex-hori flex-jc-sb">
                        <div class="button find-match @if ($isAuthenticated) authenticated @else '' @endif">
                            <span>@if ($isAuthenticated)
                                Find Match
                                @else
                                <img src="{{ asset('images/google.png') }}" alt="" width="25" height="25">
                                @endif
                            </span>
                        </div>
                        <div class="button cancel" style="display: none">
                            <span>Cancel</span>
                        </div>
                        <div class="button menu" id="render-home">
                            <span>Menu</span>
                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('js/find-match.js') }}"></script>
@endsection
