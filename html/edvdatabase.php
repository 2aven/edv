<?php

require_once 'connection.php';

function checkUserLogin($u,$p){
  global $db;
  $u = mysqli_real_escape_string($db,$u);   // Avoid SQL inyection  
  $SQLquery="SELECT username, password, email, name, surname, id
    FROM User 
    WHERE username='$u'";
  
  $DB_array = mysqli_query($db,$SQLquery) or die(mysqli_error($db));
  $loginData = mysqli_fetch_assoc($DB_array);
  if ($u==$loginData['username'] && md5($p)==$loginData['password'])
    return $loginData;
  else 
    return false;
}

?>