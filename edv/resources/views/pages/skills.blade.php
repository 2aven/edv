@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center">
  @foreach ($skills as $skill)
    @if (isset($messages["$skill->slug"]))
      <div class="alert alert-success">
      {{ $messages["$skill->slug"] }}
      </div>  
    @endif
    <div class="card w-75 bg-dark">
      <div class="card-body">
        <h3 class="card-title">{{ __("$skill->slug.name") }}</h3>
        <p class="card-text">{{ __("$skill->slug.description") }}</p>
        <a href="/skillsconf/{{ $skill->slug }}" class="btn btn-primary float-left"> {{ __("$skill->slug.confbtn") }} </a>
        <a href="/skills/{{ $skill->slug }}" class="btn btn-primary float-right"> {{ __("$skill->slug.entrybtn") }} </a>
      </div>
    </div>      
  @endforeach
</div>

@endsection