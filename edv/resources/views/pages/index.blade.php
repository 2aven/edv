@extends('layouts.app')

@section('content')
  <div>
    <div class="jumbotron text-center">
      <h1> {{ __('messages.title') }} </h1>
      <p> {{ __('messages.slogan') }} </p>
      <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
      <div class="links">
          <a href="/skills">Skills</a>
        </div>
    </div>
    <div class="links">
      <a href="/about">About</a>
    </div>
  </div>
@endsection