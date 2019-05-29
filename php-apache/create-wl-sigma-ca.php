<?php
/**
 *  Sigmas :: 50% - 68.27% - 95.45% - 99.73% 
 * 129. :: además :: 82,576 :: 541.27 >> 49995021 ----- %%% 0.49995021
 * 1255. :: jornada :: 11,097 :: 72.73 >> 68265390 ----- %%% 0.68265390
 * 40031. :: empanada :: 162 :: 1.06 >> 95449991 ----- %%% 0.95449991
*/
  function createWeightedList_es($sig = 0){
    echo "\n\n : : : \t Sigma $sig \t : : : \n\n";
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

    $handle = fopen("CAT_TAB.TXT","r");
    $wordlist = [];
    if ($handle) {
      $acum = 0.00000000;
      while ((($line = fgets($handle)) !== false)) {

        $cols = preg_split("/\s+/", $line);

        $compos=0;
        if (isset($cols[4])){
          echo "Compost: $cols[1] $cols[2] : Acum : $cols[3] \n";
          $compos=1;
        }
        $acum += (float)$cols[2+$compos];

        $percent=bcdiv($acum,8694923,8);

        if($percent > $top)  break;

        $proport=bcdiv($acum,bcmul(8694923,$top,8),8);
        echo " |$cols[0]| " . $cols[1] . ($compos?" $cols[2] ":""). " :: " . $cols[2+$compos] .
          " >> " . $acum . "----- $percent %%% ". $proport ."\n";
        array_push($wordlist,[$proport => $cols[1] . ($compos?" $cols[2] ":"")]);
      }
      array_push($wordlist,[(float)1.00000000 => "Dvorak"]);
      fclose($handle);
    }
    
    $file_result = fopen("wl_sigma$sig-ca.txt", "w");
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