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

      <!-- L o g i n - S t a t u s -->
      <li class="nav-item my-auto">
        <form class="form-inline pull-right" method="POST" 
          action="<?=$_SERVER['PHP_SELF']?>"
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
                <button class="btn btn-outline-info my-auto­" type="submit" name="create-btn" value="submit">Crea un compte</button>
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