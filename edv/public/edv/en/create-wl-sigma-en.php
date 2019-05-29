<?php
/**
 *  Sigmas :: 50% - 68.27% - 95.45% - 99.73% 
 * |Rank| word      ::      count   >>      acumulate       ----- percentage %%% proportion
 * 
 * |176|  love      ::      496496  >>      499616025       ----- 0.49961602 %%% 0.99923205
 * |1634| faithful  ::      50587.5 >>      682663503.2     ----- 0.68266350 %%% 0.99994654
 * |36663|zoetrope  ::      7.91134 >>      824355265.77817 ----- 0.82435526 %%% 0.86365140
 * 
*/
  function createWeightedList_es($sig = 0){
    echo "\n\n : : : \t Sigma $sig \t : : : \n\n";
    switch ($sig) {
      case 0:
        $top = 0.5; break;
      case 1:
        $top = 0.6827; break;

      // Sigmas 2 & 3 --> END OF FILE with ~17.5% gap
      case 2:
        $top = bcmul(0.9545,0.82435526,8); break;
      case 3:
        $top = 0.82435526; break;
      default:
        $top = 0.5; break;
    }

    $handle = fopen("EN_PG.TXT","r");
    $wordlist = [];
    if ($handle) {
      $acum = 0.00000000;
      $perbillion = 0.00000000;
      while ((($line = fgets($handle)) !== false)) {

        $cols = preg_split("/\s+/", $line);

        
        $acum += (float)$cols[2];

        $perbillion=bcdiv($acum,1000000000,8);

        if($perbillion > $top) 
          break;

        $proport=bcdiv($acum,bcmul(1000000000,$top,8),8);
        echo " |$cols[0]|\t" . $cols[1] . "\t::\t" . $cols[2] .
          " \t>>\t" . $acum . "\t----- $perbillion %%% ". $proport ."\n";
        array_push($wordlist,[$proport => $cols[1]]) ;
      }

      array_push($wordlist,[(float)1.00000000 => "Dvorak"]);
      fclose($handle);
    }
    
    $file_result = fopen("wl_sigma$sig-en.txt", "w");
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