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
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <!-- Aditional CSS (overlap) -->
  <!-- <link rel="stylesheet" href="css/style.css"> -->
</head>
<body>
  
  <?php 
    require_once 'functions.php';
    require_once 'edvdatabase.php';
    require_once 'login.php';
    require_once 'header.php';
  ?>

  <!-- Content -->
    <div class="container" id="Skill-list">
      <div class="row justify-content-center">
        <div class="col"> </div> <!-- Auto-col, depends on the size of the next column (xs-sm-md-lg) -->
        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-8">

          <?php
            // funcio-llista-skills ()
          ?>
    
        </div>
        <div class="col"> </div>
      </div>

    </div> 
    <!-- END: Skills - container -->

    <?php require_once 'footer.php'; ?>
  </body>
</html>