@extends('layouts.app', ['title' => 'Shop'])

@section('styles')

@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area">
        <div class="eq-header flex flex-jc-sb">
            <div class="left-side flex flex-vert flex-ai-fs flex-jc-sb">
                <button class="header-btn" id="settings">
                    <img src="/images/Settings.png" alt="settings">
                </button>
                <button class="header-btn" id="profile">
                    <img src="/images/User Profile.png" alt="profile">
                </button>
                <button class="header-btn hide" id="exit-game">
                    <img src="/images/Exit.png" alt="exit-game">
                </button>
            </div>
            <div class="game-logo flex flex-jc-c">
                <div class="logo-container" id="classic-logo">
                    <img src="/images/Shop logo.png" alt="EquaSolve-Logo">
                </div>
            </div>
            <div class="right-side flex flex-vert flex-ai-fe flex-jc-sb">
                <div class="input-container hide">
                    <span class="mmr">MMR:</span>
                    <input readonly type="text" class="eq-mmr" id="mmr" placeholder="{{auth()->user()->pvpModeDetails->mmr}}">
                    <span class="mmr-2">MMR: </span>
                </div>
                <div class="input-container">
                    <span class="trophy">Trophy:</span>
                    <input readonly type="text" class="eq-trophy" id="trophy" placeholder="{{auth()->user()->classicModeDetails->trophies}}">
                    <div class="img-container"></div>
                </div>
            </div>
        </div>

        <div class="eq-mm-container">
            <div class="eq-title-container">
                <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                    <h1 class="welcome-text">
                        Welcome to Shop!
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

        <div class="game-theme-container">
            <div class="theme-menu flex flex-vert flex-jc-sb">
                @foreach ($backgrounds as $background)

                <div class="@if($background->isOwned) active-theme @else locked-theme @endif @if($background->isActivated) default @endif theme-for-sale"
                    data-id="{{$background->id}}" data-theme="{{$background->css_theme}}">
                    <div class="input-container">
                        <span class="trophy">Trophy:</span>
                        <input readonly type="text" class="eq-trophy" id="trophy" placeholder="{{ $background->price }}">
                        <div class="img-container2"></div>
                    </div>
                    <div id="{{$background->theme_id}}" class="menu-btn flex">
                        <div class="img-container">
                            <img src="/images/Logo.png" alt="Classic-logo">
                        </div>
                        <div class="text-container flex flex-ai-fs flex-vert flex-jc-c">

                            <div class="upper-text flex flex-hori flex-jc-sb">
                                <h2>{{$background->name}}</h2>
                                <span class="us"></span>
                            </div>
                            <p>Available Colors: @if($background->isActivated) (default) @endif</p>

                            <div class="color-container flex">
                                <span class="colors" id="color-1"></span>
                                <span class="colors" id="color-2"></span>
                                <span class="colors" id="color-3"></span>
                                <span class="colors" id="color-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>


    </div>
</section>

<div class="eq-version flex flex-jc-c">
    <span>Version Alpha.</span>
</div>
@endsection

@section('scripts')
{{-- <script src="{{ asset('js/shop.js') }}"></script> --}}
@endsection
