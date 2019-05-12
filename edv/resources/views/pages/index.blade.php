@extends('layouts.app')

@section('content')
  <div>
    <div class="jumbotron text-center">
      <h1> {{ __('messages.title') }} </h1>
      <p> {{ __('messages.slogan') }} </p>
    </div>

    <div class="links">
      <a href="/about">About</a>
    </div>
  </div>
@endsection
