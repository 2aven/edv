@extends('layouts.app')
@section('content')

  <div class="jumb otron text-center">
    <ul>
    @foreach ($skillsConf as $skillConf)
        <li>
        {{ var_dump($skillConf) }}
        </li>
      @endforeach
    </ul>
  </div>
  
    
@endsection