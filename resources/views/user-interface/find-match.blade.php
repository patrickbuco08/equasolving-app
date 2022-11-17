@extends('layouts.app', ['title' => 'Find Match'])

@section('styles')
{{-- css here --}}
@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area vh-100">
        <div id="find-match">
            <main>
                <div class="content">
                    <div class="logo"></div>
                    <div class="button find-match">
                        <span>Connecting...</span>
                    </div>
                    <div class="button cancel" style="display: none">
                        <span>Cancel Queue</span>
                    </div>
                    <div class="tips">
                        <span><b>Tips: </b> There are times where fear is good.</span>
                    </div>
                </div>
                <div class="button menu" id="render-home">
                    <span>MENU</span>
                </div>
            </main>
            <footer>
                <p>Version Alpha.</p>
            </footer>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/find-match.js') }}"></script>
@endsection
