<?php

function mostratxt($n = 300){
  $handle = fopen("skills/edv/CREA_parcial.TXT", "r");
  if ($handle) {
    $paraules = [];
    $acum = 0;
    // echo 
    fgets($handle) . "\tFrec. Acumulada<br>";
    while (($line = fgets($handle)) !== false) {
      // echo $line . "<br>";
      $cols = preg_split("/\s+/", $line);

      $acum += (float)$cols[4]*100.00;
      // echo " |$cols[0]| " . $cols[1] . " :: " . $cols[2] . " :: " . $cols[3] . " :: " . $cols[4] . " >> " . $acum . "<br>";
      //   // process the line read.
      array_push($paraules,$cols[2]);
      
    }
    // echo "0. \tzweig \t0 \t0 \t " . (100000000-$acum);

    fclose($handle);

    return $paraules;

  } else {
      echo "Mal asumpte";
      // error opening the file.
  } 
}

$textProva = mostratxt(300);


  
?>

<link rel="stylesheet" href="skills/edv/style.css">

<div class="bg-dark text-white ">
  <header class="bg-secondary text-center p-3 mb-5">
    <h1>WordBeater</h1>
  </header>
  <div class="container text-center">

    <!-- Word & Input -->
    <div class="row">
      <div class="col-md-6 mx-auto">
        <p class="lead">Type The Given Word Within
          <span class="text-success" id="seconds">5</span> Seconds:</p>
        <h2 class="display-2 mb-5" id="current-word">hello</h2>
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
  </div>
</div>

<script>
  const words = <?= '["' . implode('", "', $textProva) . '"]'?>;
</script>
<script src="skills/edv/main.js"></script>


