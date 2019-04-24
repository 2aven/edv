<?php
  if(   (isset($_POST['logout-btn']) && $_POST['logout-btn']=="submit")
    ||  (isset($_POST['login-desist']) && $_POST['login-desist']=="submit")
    ){
      session_unset();
      session_destroy();
  }
  
  if(isset($_POST['login-submit']) && $_POST['login-submit']=="submit"){
    
    $loginData=checkUserLogin(
      $_POST['InputUser'],
      $_POST['InputPassword']);
      /* in case there's no data, returns: false */
    if ($loginData){
      /* INIT - SESSION WITH DB-DATA */    
      $_SESSION['usr']    = $loginData['nomusr'];
      $_SESSION['email']  = $loginData['email'];
      $_SESSION['name']   = $loginData['nom'];
      $_SESSION['alias']  = $loginData['alies'];
      $_SESSION['id']     = $loginData['userID'];
      $_SESSION['stat']   = true;
    } else {
      $_SESSION['stat']   = false;    // Failed login attempt
    }
  }
?>