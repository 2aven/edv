@extends('layouts.app')

@section('content')
  <div>
    <div class="jumbotron text-center">
      <h1> {{ __('messages.title') }} </h1>
      <p> {{ __('messages.slogan') }} </p>
      <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
    </div>
    <div>
      @if (count($skillsData))
      <ul class='list-group-dark'>
        @foreach($skillsData as $sn => $skillData)
        
        <h3>{{$sn}}</h3>
        {{-- PER QUAN ARRIBIN LES DADES DE LA DB
          // ** borrar $sn del foreach ** //

          <h3>{{$skillData['nomsk']}}</h3>
            <li class='list-group-item-dark'>
              <a href="{{$skillData['ruta']}}">
                <img src="{{$skillData['imatge']}}"/>
              </a>
            </li> --}}  
          
          @endforeach
      </ul> 
      @else
        <div> MESSAGES:: NO hi ha skills :( </div>
      @endif
    </div>
    <div class="links">
      <a href="/about">About</a>
    </div>
  </div>
@endsection