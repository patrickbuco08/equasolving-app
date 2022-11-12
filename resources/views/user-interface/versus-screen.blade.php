@extends('layouts.app', ['title' => 'Versus Screen'])

@section('styles')
{{-- CSS Here --}}
@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area vh-100">
        <div id="versus-screen">
            <main>
                <div class="container">
                    <div>
                        <span>Player #1</span>
                        <div class="player one"></div>
                        <div class="player-mmr">500</div>
                    </div>
                    <span class="versus">VS</span>
                    <div>
                        <span>Player #2</span>
                        <div class="player two"></div>
                        <div class="player-mmr">510</div>
                    </div>
                </div>
                <div class="eq-title-container">
                    <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                        <h1 class="welcome-text">
                            PVP Mode Loading...
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
            </main>
            <footer>
                <p>Version Alpha.</p>
            </footer>
        </div>
    </div>
</sectio
@endsection

@section('scripts')
<script>

</script>
@endsection
