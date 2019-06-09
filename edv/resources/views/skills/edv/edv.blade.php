@extends('layouts.app')
@section('content')

<div class="jumb otron text-center">
  <h1> {{ __('edv.title') }} </h1>
  <p> {{ __('edv.slogan') }} </p>
</div>  

<div class="container justify-content-center">
  
  <div class="row">
    <div class="col-md-6 mx-auto text-justify">
      @foreach ($wordlist as $w => $word)
      <span class="word-stream" id="w-{{$w}}">{{$word}}</span>
      @endforeach
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-6 mx-auto text-center">
      <h2 class="display-2 mb-5" id="current-word">·</h2>
      <input type="text" class="form-control form-control-lg"
      placeholder="· · ·" id="word-input" autofocus>
      <h4 class="mt-3" id="message"></h4>
      
      <div class="row mt-5">
        <div class="col-md-6">
          <h3>Time:
            <span id="time">00:00.0</span>
          </h3>
        </div>
        <div class="col-md-6">
          <h3>PPM:
            <span id="ppm">0</span>
          </h3>
        </div>
      </div>
      
      <div class="row mt-5">
        <div class="col-md-12">
          <div class="card card-body bg-secondary text-white">
            <h5>Instructions</h5>
            <p>Type each word while I take indirect measurements of your brain activity</p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  
    <div class="text-center">
      {{ Form::open(['action' => 'CoffretController@store','id' => 'stadistics']) }}
        <div class="form-group">
          {{ Form::hidden('skill', 'edv') }}
          {{ Form::hidden('vresults', '{ "t":0, "pacum":0, "wrong": [] }', 
            ['class' => 'form-control','id' => 'vresults', 'readonly']) }}
        </div>
      {{ Form::close() }}
    </div>
</div>

@push('skill-script')
<script src={{ asset('edv/js/edv.js') }}></script>
@endpush

@endsection