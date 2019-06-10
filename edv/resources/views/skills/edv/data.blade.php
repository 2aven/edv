@extends('layouts.app')
@section('content')

<div class="jumbotron text-center">
  <h1> {{ __('edv.results') }} </h1>
</div>  
<div class="justify-content-center">
  <div class="row">
    <div class="col-md-6 mx-auto text-justify">
      <div class="card bg-dark">
        <div class="card-header">
          <h4> {{ __('edv.ppmin') }} </h4>
        </div>
        <div class="card-body">
          <ul class="list-group">
            <li class="list-group-item list-group-item-dark">
              <span>{{ round($vresults['pacum']*600/$vresults['t'],2) }} {{ __('edv.ppm')}} </span>
            </li>
          </ul>
          <br>
          <a href="/coffret/edv" class="btn btn-info float-left"> {{ __("edv.coffretbtn") }}</a>
          <a href="/skills/edv" class="btn btn-primary float-right"> {{ __("edv.skillbtn") }}</a>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-6 mx-auto text-justify">
      <div class="card bg-dark">
          <div class="card-header">
            <h5> {{__('edv.wrongs') }} </h5>
          </div>
          <div class="card-body">
            <ul class="list-group">
              @foreach ($vresults['wrong'] as $wrong)
              <li class="list-group-item list-group-item-dark">
                  {{$wrong[0]}}: {{$wrong[1]}}
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection