<?php

  define("DB_HOST","edv-database");
  define("DB_USER","nom_usuari");
  define("DB_PASS", "contrasenya_usuari");
  define("DB_NAME","nom_base_de_dades");
  define("DB_PORT", "3306");
  
  $db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  if (!$db){
      die("Ho sento moltíssim però... La connexió amb la base de dades ha fallat!");
  }
  mysqli_set_charset($db, "utf8");

?>