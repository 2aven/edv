@extends('layouts.app')
@section('content')

<div class="jumb otron text-center">
  <h1> {{ __('edv.title') }} </h1>
  <p> {{ __('edv.slogan') }} </p>
</div>  

<div class="container justify-content-center">
  <div class="row">
    <div class="col-md-6 mx-auto text-justify">

      <h4> Results: </h4>
      <p>PPM: {{ round($vresults['pacum']*600/$vresults['t'],2) }} </p>
      <p>Wrong words:</p>
      <ul>
        @foreach ($vresults['wrong'] as $wrong)
        <li>
            {{$wrong[0]}}: {{$wrong[1]}}
         </li>
        @endforeach
      </ul>

    </div>
  </div>
</div>
@endsection