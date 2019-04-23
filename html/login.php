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
            <label for="InputPassword"><strong>Contrassenya</strong></label>
            <input type="password" class="form-control" name="InputPassword" id="InputPassword" placeholder="Password">
          </div>
          <button type="submit" name="login-submit" value="submit" class="btn btn-primary">Envia</button>
          <button type="submit" name="login-desist" value="submit" class="btn btn-primary pull-right">Tanca</button>
        </form>
      </div>
    </div>
  </div>