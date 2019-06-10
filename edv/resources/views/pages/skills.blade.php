@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
  @foreach ($skills as $skill)
    @if (isset($messages["$skill->slug"]))
      <div class="alert alert-success">
      {{ $messages["$skill->slug"] }}
      </div>  
    @endif
    <div class="card  bg-dark">
      <div class="card-header">
        <h3 class="card-title float-left">{{ __("$skill->slug.name") }}</h3>
        <a href="/skillsconf/{{ $skill->slug }}" class="btn btn-secondary float-right"> {{ __("$skill->slug.confbtn") }} </a>
      </div>
      <div class="card-body">
        <p class="card-text">{{ __("$skill->slug.description") }}</p>
        <br>
        <a href="/coffret/{{ $skill->slug }}" class="btn btn-info float-left"> {{ __("$skill->slug.coffretbtn") }} </a>
        <a href="/skills/{{ $skill->slug }}" class="btn btn-primary float-right"> {{ __("$skill->slug.entrybtn") }} </a>
      </div>
    </div>      
  @endforeach
</div>

@endsection