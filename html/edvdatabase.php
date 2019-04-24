<?php

require_once 'connection.php';

function checkUserLogin($u,$p){
  global $db;
  $u = mysqli_real_escape_string($db,$u);   // Avoid SQL inyection  
  $SQLquery="SELECT nomusr, passwd, email, nom, alies, userID
    FROM usuari 
    WHERE nomusr='$u'";
  
  $DB_array = mysqli_query($db,$SQLquery) or die(mysqli_error($db));
  $loginData = mysqli_fetch_assoc($DB_array);
  if ($u==$loginData['nomusr'] && md5($p)==$loginData['passwd'])
    return $loginData;
  else 
    return false;
}

function comprovaFormulari(){
  if ( ($_POST['InputUser'] == NULL)
  || ($_POST['InputBdate'] == NULL)
  || ($_POST['InputEmail'] == NULL)
  || ($_POST['InputPassword'] == NULL)
  ) return false;
  
  if ($_POST['InputName'] == NULL)
    $_POST['InputName'] = $_POST['InputUser'];
  if ($_POST['InputAlias'] == NULL)
    ($_POST['InputName'] == NULL)?$_POST['InputAlias'] = $_POST['InputUser']:$_POST['InputAlias'] = $_POST['InputName'];
  
  global $db;
  $u = mysqli_real_escape_string($db,$_POST['InputUser']);   // Avoid SQL inyection  
  $SQLquery="SELECT nomusr FROM usuari WHERE nomusr='$u'";
  $DB_array = mysqli_query($db,$SQLquery) or die(mysqli_error($db));
  $loginData = mysqli_fetch_assoc($DB_array);
  
  if ($u==$loginData['nomusr']) {
    echo "L'usuari " . $u . " ja existeix";
    return false;
  }
  else {
    return true;
  }
}

function crearUsuari(){
  // $_POST ha de venir filtrat amb real_escape_string quan passa per comprovaFormulari()
  global $db;
  $SQLquery="INSERT INTO usuari SET  
    nomusr = '" . $_POST['InputUser'] . "',
    passwd = '" . md5($_POST['InputPassword']) . "',
    email = '" . $_POST['InputEmail'] . "',
    nom = '" . $_POST['InputName'] . "',
    alies = '" . $_POST['InputAlias'] ."'";
    // naix = " . $_POST['InputBdate'] . "',"

  mysqli_query($db,$SQLquery) or die (mysqli_error($db));
  echo "Usuari creat, estrena'l!";
}

?>