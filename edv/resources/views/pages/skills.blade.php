@extends('layouts.app')

@section('content')

  @foreach ($skills as $skill)

  <div class="card w-75 bg-dark">
      <div class="card-body">
        <h3 class="card-title">{{ __("$skill->slug.name") }}</h3>
        <p class="card-text">{{ __("$skill->slug.description") }}</p>
        <a href="/skills/{{ $skill->slug }}" class="btn btn-primary"> {{ __("$skill->slug.entry") }} </a>
      </div>
    </div>      
  @endforeach
    
@endsection