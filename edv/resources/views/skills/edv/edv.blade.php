<?php
/**
 *  Sigmas :: 50% - 68.27% - 95.45% - 99.73% 
 * 129. :: además :: 82,576 :: 541.27 >> 49995021 ----- %%% 0.49995021
 * 1255. :: jornada :: 11,097 :: 72.73 >> 68265390 ----- %%% 0.68265390
 * 40031. :: empanada :: 162 :: 1.06 >> 95449991 ----- %%% 0.95449991
*/

  function getWordList($sigma = 1){
    $handle = fopen("edv/es/wl_sigma$sigma-es.txt","r");
    if ($handle) {
      $wordlist = [];
      while (($line = fgets($handle)) !== false) {
        $cols = preg_split("/\s+/", $line);
        array_push($wordlist,[$cols[1],$cols[2]]);
      }
    fclose($handle);

    return $wordlist;

    } else 
      return 0;  // error opening the file.
  }

  // $n in getWordList --->>> from: Config
  $wordlist = getWordList();
?>

@extends('layouts.app')
@section('content')

  <div class="jumb otron text-center">
    <h1> {{ __('edv.title') }} </h1>
    <p> {{ __('edv.slogan') }} </p>
  </div>  

  <h1> WORD STREAM </h1>
  
  <!-- Word & Input -->
  <div class="row">
    <div class="col-md-6 mx-auto">
      <p class="lead">Type The Given Word Within
        <span class="text-success" id="seconds">5</span> Seconds:</p>
      <h2 class="display-2 mb-5" id="current-word"> = = = </h2>
      <input type="text" class="form-control form-control-lg" placeholder="Start typing..." id="word-input" autofocus>
      <h4 class="mt-3" id="message"></h4>

      <!-- Time & Score Columns -->
      <div class="row mt-5">
        <div class="col-md-6">
          <h3>Time Left:
            <span id="time">0</span>
          </h3>
        </div>
        <div class="col-md-6">
          <h3>Score:
            <span id="score">0</span>
          </h3>
        </div>
      </div>

      <!-- Instructions -->
      <div class="row mt-5">
        <div class="col-md-12">
          <div class="card card-body bg-secondary text-white">
            <h5>Instructions</h5>
            <p>Type each word in the given amount of seconds to score. To play again, just type the current word. Your score
              will reset</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const words = <?=json_encode($wordlist);?>;
  </script>
  <script src="edv/js/edv.js"></script>
  

@endsection