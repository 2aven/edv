<?php

require_once 'connection.php';

function checkUserLogin($u,$p){
  global $db;
  $u = mysqli_real_escape_string($db,$u);   // Avoid SQL inyection  
  $SQLquery="SELECT nomusr, passwd, email, nom, alies, id
    FROM usuari 
    WHERE nomusr='$u'";
  
  $DB_array = mysqli_query($db,$SQLquery) or die(mysqli_error($db));
  $loginData = mysqli_fetch_assoc($DB_array);
  if ($u==$loginData['nomusr'] && md5($p)==$loginData['passwd'])
    return $loginData;
  else 
    return false;
}

function crearUsuari($PostData){
  var_dump($PostData);
}

?>