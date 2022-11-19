<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="google-signin-client_id" content="{{env('GOOGLE_APP_ID')}}">
    <title>{{ $title ?? 'EquaSolve' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/style_v2/style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/classic/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    @yield('styles')
</head>

<body id="main-default">

    <div id="root" style="width: inherit; height: inherit; display: contents">
        @yield('content')
    </div>

    <section id="overlay" class="hid">
        <div id="modal" class="modal">
            <div class="modal-content">
                <div id="unlock-theme" class="unlock-theme">
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h3 class="welcome-text">
                                    Purchase Theme?
                                </h3>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
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
                    <div class="modal-button-container flex flex-hori flex-jc-sb">
                        <button class="purchase-btn" id="purchase">Purchase</button>
                        <button class="cancel-btn" id="cancel">Cancel</button>
                    </div>
                </div>
    
                <div id="error-modal" class="error-modal">
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h3 class="welcome-text">
                                    Insufficient trophies..
                                </h3>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
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
                    <button class="okay-btn" id="okay">Okay</button>
                </div>
    
                <div id="success-modal" class="success-modal">
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h3 class="welcome-text">
                                    Theme Purchased!
                                </h3>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
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
                    <button class="okay-btn" id="okay">Okay</button>
                </div>
    
                <div id="equip-modal" class="equip-modal">
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h3 class="welcome-text">
                                    Equip theme?
                                </h3>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
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
                    <div class="modal-button-container flex flex-hori flex-jc-sb">
                        <button class="equip-btn" id="equip">Equip</button>
                        <button class="cancel-btn" id="cancel">Cancel</button>
                    </div>
                </div>
    
                <div id="theme-equip-modal" class="theme-equip-modal">
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h3 class="welcome-text">
                                    Theme Equiped!
                                </h3>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
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
                    <button class="okay-btn" id="okay">Okay</button>
                </div>
    
                {{-- fx settings --}}
                <div id="settings" class="settings">
                    <div class="eq-mm-container">
                        <div class="eq-title-container">
                            <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                                <h3 class="welcome-text">
                                    Settings
                                </h3>
                            </div>
                            <div class="square flex flex-hori flex-jc-sb exit-context-box ">
                                <div class="square-left flex flex-vert flex-jc-sb">
                                    <span class="us"></span>
                                    <span class="us"></span>
                                </div>
                                <div class="square-right flex flex-vert flex-jc-sb">
                                    <span class="us"></span>
                                    <span class="us"></span>
                                </div>
                            </div>
                            <div class="flex flex-hori flex-ai-c flex-jc-sb">
                                <h4>Music:</h4>
                            <span class="header-btn" id="musicOnOff">
                                <img id="musicImg" src="{{ asset('images/music-on.png') }}" alt="BGMusic">
                            </span>
                            </div>
                            <div class="flex flex-hori flex-ai-c flex-jc-sb">
                                <h4>SFX:</h4>
                            <span class="header-btn" id="SFXOnOff">
                                <img id="sfxImg" src="{{ asset('images/music-on.png') }}" alt="BGMusic">
                            </span>
                            </div>
                        </div>
                    </div>
                    <button class="okay-btn" id="okay">Close</button>
                </div>
            </div>
        </div>
    
    </section>

    <script src="{{ asset('js/navigator.js') }}"></script>
    <script>

    </script>
    @yield('scripts')
</body>

</html>
