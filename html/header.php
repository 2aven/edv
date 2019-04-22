<div class="container junstify-content-center">
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.php">
      <span class="text-success display-4 veganreview-logo">D&#x24CB</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item my-auto">
          <a class="nav-link" href="index.php"><strong>Area:</strong> Palma</a>
        </li>
        <!--
        <li class="nav-item dropdown my-auto">
          <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Relevance
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="index.php">Alphabetic order</a>
            <a class="dropdown-item" href="index.php">Relevance</a>
            <a class="dropdown-item" href="index.php">Average price</a>
            <a class="dropdown-item" href="index.php">Popularity</a>
          </div>
        </li>
      -->
      
      <!-- L o g i n - S t a t u s -->
      <li class="nav-item my-auto">
        <form class="form-inline pull-right" method="POST" 
          action="<?= $_SERVER['PHP_SELF'] ?>"
          onsubmit="<?=(isset($_SESSION['stat']) && $_SESSION['stat'])?
            "return confirm('Do you really want to Logout?');":
            ''?>"
          >
          <!-- Select Login / Logout button -->
          <?php
            if (isset($_SESSION['stat']) && $_SESSION['stat']){
              ?>
              <div class="container justify-content-center">
                <div class="row">
                  <div class="col my-auto">
                    <img src="img/anonymous.png" alt="Anonymous"/>
                  </div>
                  <div class="col my-auto">
                    <div class="row">
                      <div class="col text-center">
                        <small><strong>Bones, <?=$_SESSION['name']?>!</strong></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col text-center">
                        <small><?=$_SESSION['email']?></small>
                      </div>
                    </div>
                  </div>
                  <button class="btn btn-outline-warning my-auto" type="submit" name="logout-btn" value="submit">Log out</button>
                </div>
              </div>
              <?php
            } else {
              ?>
                <button class="btn btn-outline-info my-auto­" type="submit" name="login-btn" value="submit">Log in</button>
              <?php
            }
            ?>
        </form>
      </li>
      <!-- E n d - L o g i n -->
      </ul>
      
    </div>
  </nav>       
</div>
<?php
  
  if(   (isset($_POST['login-btn'])     && $_POST['login-btn']=="submit" )  // Login button
    ||  (isset($_POST['login-submit'])  && $_SESSION['stat']==false )       // Failed login attempt
    ){
      /* :: PRINT LOGIN FORM :: 
      * It can be called from:
      *  - the header's [Login] button
      *  - the Login Form in failed login case
      */
    ?>
      <div class="container">
        <div class="row">
          <div class="col"> </div>
          <div class="col-xs-6 col-sm-6 col-md-5 col-lg-4">
            <?= ((isset($_SESSION['stat'])) && ($_SESSION['stat']==false)) ?  // Check origin: Failed login attempt
              "<p class='text-warning'><strong>Invalid user or password</strong></p>" :
              ''?>
            <form method="POST" 
              action="<?= $_SERVER['PHP_SELF'] ?>"
                > 
              <div class="form-group">
                <label for="InputUser"><strong>Usuari</strong></label>
                <input type="user" class="form-control" name="InputUser" id="InputUser" placeholder="Enter user">
              </div>
              <div class="form-group">
                <label for="InputPassword"><strong>Password</strong></label>
                <input type="password" class="form-control" name="InputPassword" id="InputPassword" placeholder="Password">
              </div>
              <button type="submit" name="login-submit" value="submit" class="btn btn-primary">Submit</button>
              <button type="submit" name="login-desist" value="submit" class="btn btn-primary pull-right">Close</button>
            </form>
          </div>
        </div>
      </div>
    <?php 
  }
?>