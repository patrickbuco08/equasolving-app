@extends('layouts.app', ['title' => 'Set Nickname'])

@section('styles')
{{-- CSS Here --}}
@endsection

@section('content')
<section id="content-section">
    <div class="eq-content-area">

         <div class="eq-header flex flex-jc-c">
             <div class="game-logo flex flex-jc-c">
                 <div class="logo-container" id="main-logo">
                     <img src="{{ asset('images/Logo.png') }}" alt="EquaSolve-Logo">
                 </div>
             </div>
         </div>  

         <div class="eq-nn-container">
             <div class="eq-title-container ">
                 <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                     <h1 class="welcome-text">
                         Welcome To EquaSolve.
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
                 <div class="eq-sub-text">
                     <p>Solving Equations and matching the results
                         from sorted random numbers for learning
                         basic arithmetic methods.</p>
                 </div>
             </div>
         </div>

         <div class="eq-set-nickname">
             <div class="eq-nickname-container flex flex-jc-c flex-vert">
                 <div class="eq-title-area flex flex-vert flex-jc-sb flex-ai-c">
                     <input type="text" class="set-nickname" name="set-nickname" placeholder="Set Nickname">
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
                 <span id="restrictions" class="nickname-restrictions">No Special Characters</span>
             </div>
             <div class="eq-button-area flex flex-hori flex-jc-sb">
                 <button type="button" class="eq-submit flex flex-jc-c flex-ai-c" name="add-nickname" disabled> Submit </button>
                 <form action={{ route('google.login') }} method="GET">
                    <button type="submit" class="eq-connect flex flex-jc-c flex-ai-c"> <img src="{{ asset('images/google.png') }}" alt=""> Connect </button>                
                 </form>
             </div>
         </div>
     </div>
 </section>

 <div class="eq-version flex flex-jc-c">
     <span>Version Alpha.</span>
 </div>
@endsection

@section('scripts')
<script>
(() => { 

 })();
</script>
@endsection
