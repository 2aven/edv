@extends('layouts.app')
@section('content')

  <div class="jumb otron text-center">
    <ul>
    @foreach ($skillsConf as $slug => $skillConf)
        <li>
          {{ __("$slug.title") }}
          {{ var_dump($skillConf) }}
          <a href="/skillsconf/{{ $slug }}"> {{ __("$slug.conflink") }} </a>  
        </li>
      @endforeach
    </ul>
  </div>
  
    
@endsection