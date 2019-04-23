<?php
  session_start();
  ?>
<!doctype html>
<html lang="ca"> <!-- ACTUALITZAR DEPENENT DE L'IDIOMA -->
<head>
  <title>Entrenador Dvorak</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  <!-- Add icon library (Social Networks) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Aditional CSS (overlap) -->
  <!-- <link rel="stylesheet" href="css/style.css"> -->
</head>
<body>
  
  <?php 
    require_once 'functions.php';
    require_once 'edvdatabase.php';
    require_once 'session.php';
    require_once 'header.php';


    if(   (isset($_POST['login-btn'])     && $_POST['login-btn']=="submit" )  // Login button
    ||  (isset($_POST['login-submit'])  && $_SESSION['stat']==false )       // Failed login attempt
    ){
      require_once 'login.php';
    } else if (isset($_POST['create-btn']) && $_POST['create-btn']=="submit") {  // Create button
      require_once 'signin.php';
    } else if (isset($_POST['create-submit']) && $_POST['create-submit']=="submit") {  // Create form
      crearUsuari($_POST);
    } else {
      require_once 'home.php';
    }
    
    require_once 'footer.php';
    ?>
  </body>
</html>