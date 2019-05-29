<?php
/**
 *  Sigmas :: 50% - 68.27% - 95.45% - 99.73% 
 * 129. :: además :: 82,576 :: 541.27 >> 49995021 ----- %%% 0.49995021
 * 1255. :: jornada :: 11,097 :: 72.73 >> 68265390 ----- %%% 0.68265390
 * 40031. :: empanada :: 162 :: 1.06 >> 95449991 ----- %%% 0.95449991
*/
  function createWeightedList_es($sig = 0){
    switch ($sig) {
      case 0:
        $top = 0.5; break;
      case 1:
        $top = 0.6827; break;
      case 2:
        $top = 0.9545; break;
      case 3:
        $top = 1; break;
      default:
        $top = 0.5; break;
    }

    $handle = fopen("CREA_parcial.TXT","r");
    $wordlist = [];
    if ($handle) {
      $acum = 0.00000000;
      // echo
        fgets($handle) . "\tFrec. Acumulada<br>"; // Jump the first header line
      while ((($line = fgets($handle)) !== false)) {
        // echo $line . "<br>";

        $cols = preg_split("/\s+/", $line);

        $acum += (float)$cols[4]*100.00;
        $permillion=bcdiv($acum,100000000,8);

        if($permillion > $top)  break;

        $proport=bcdiv($acum,bcmul(100000000,$top,8),8);
        // echo " |$cols[0]| " . $cols[1] . " :: " . utf8_encode($cols[2]) . " :: " . $cols[3] . " :: " .
        //   $cols[4] . " >> " . $acum . " ----- %%% ". $proport ."<br>";
        array_push($wordlist,[$proport => utf8_encode($cols[2])]);
      }
      array_push($wordlist,[(float)1.00000000 => "Dvorak"]);
      fclose($handle);
    }
    
    $file_result = fopen("edv/es/wl_sigma$sig-es.txt", "w");
    foreach ($wordlist as $n => $word) {
      $fline = $n+1 . "\t";
      foreach ($word as $pweight => $w) {
        
        $fline .= $pweight ."\t".$w."\n";
      }
      fwrite($file_result, $fline);
    }
    fclose($file_result);

    return $wordlist;
  }


  for($i=0;$i<4;$i++)
    $words = createWeightedList_es($i);
?>