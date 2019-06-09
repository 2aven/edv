@extends('layouts.app')
@section('content')

  <div class="text-center">
    {{ Form::open(['action' => 'SkillConfController@store']) }}
      <div class="form-group">
        <ul>
          <li>
            {{ Form::label("method",__("edv.method")) }}
            {{ Form::select("method", [
                "text" => __("edv.text_method"),
                "word" => __("edv.word_method"),
                "syl" =>  __("edv.syllabic_method")
                ], $vconf['method'],['class' => 'form-control'])}}
          </li>
          <li>
            {{ Form::label("lang",__("edv.lang")) }}
            {{ Form::select("lang", [
                "ca" => __("edv.ca_lang"),
                "es" => __("edv.es_lang"),
                "en" => __("edv.en_lang")
                ], $vconf['lang'],['class' => 'form-control'])}}
          </li>
          <li>
            {{ Form::label("keymap",__("edv.keymap")) }}
            {{ Form::select("keymap", [
                "dv" => __("edv.dv_keymap"),
                "querty" => __("edv.querty_keymap")
                ], $vconf['keymap'],['class' => 'form-control'])}}
          </li>
          {{ Form::label("sigma",__("edv.sigma")) }}
          {{ Form::select("sigma", [
              "0" => __("edv.sigma_0"),
              "1" => __("edv.sigma_1"),
              "2" => __("edv.sigma_2"),
              "3" => __("edv.sigma_3")
              ], $vconf['sigma'],['class' => 'form-control'])}}
          </li>
          <li>
            {{ Form::checkbox("reptwords", "true" , array_key_exists("reptwords",$vconf) )}}
            {{ Form::label("reptwords",__("edv.reptwords")) }}
          </li>
          <li>
            {{ Form::checkbox("backspc", "true" , array_key_exists("backspc",$vconf) )}}
            {{ Form::label("backspc",__("edv.backspc")) }}
          </li>
        </ul>
      </div>
      {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
@endsection