@extends('layouts.app')
@section('content')

<div class="jumb otron text-center">
  <h1> {{ __('edv.statistics') }} </h1>
</div>  

<div class="justify-content-center">
@if ($statistics)
    <div class="row">
      <div class="col-md-6 mx-auto text-justify">
        <div id="statistics"></div>
        {!! \Lava::render('LineChart', 'statistics', 'statistics') !!}
      </div>
    </div>
  </div>
  <br>
@endif

  <div class="row">
    <div class="col-md-6 mx-auto text-justify">
      <div id="ppmnormal"></div>
      {!! \Lava::render('ColumnChart', 'ppmnormal', 'ppmnormal') !!}
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-6 mx-auto text-justify">
      <div id="wpmnormal"></div>
      {!! \Lava::render('ColumnChart', 'wpmnormal', 'wpmnormal') !!}
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-6 mx-auto text-justify">
      <a href="/skills" class="btn btn-primary float-left"> {{ __("messages.skills") }}</a>
      <a href="/skills/edv" class="btn btn-primary float-right"> {{ __("edv.skillbtn") }}</a>
    </div>
  </div>
</div>
  
@endsection