@extends('layouts.app')
@section('content')

  <div class="text-center">
    {{ Form::open(['action' => 'SkillConfController@store']) }}
      <div class="form-group">
        <ul> @foreach ($vparam as $key => $options)
          <li>
            {{ Form::label("$key",__("$slug.$key")) }}
            {{ Form::select("$key",$options,$vconf[$key],['class' => 'form-control'])}}
          </li> @endforeach
        </ul>
      </div>
      {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
  
@endsection