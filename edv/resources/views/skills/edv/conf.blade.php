@extends('layouts.app')
@section('content')

  <div class="jumb otron text-center">
    {{ var_dump($skillConf) }}
    {{ Form::open(['action' => 'SkillConfController@store']) }}
      <div class="form-group">
        <ul> @foreach (json_decode($skillConf) as $key => $conf)
          <li>
            {{ Form::label('title',__("$slug.$key")) }}
            {{ Form::text('title',$conf,['class' => 'form-control', 'placeholder' => "$conf"])}}
          </li> @endforeach
        </ul>
      </div>
    {{ Form::close() }}
  </div>
  
@endsection