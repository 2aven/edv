  <div class="container">
    <div class="row">
      <div class="col"> </div>
      <div class="col-xs-6 col-sm-6 col-md-5 col-lg-4">
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
          <div class="form-group">
            <label for="InputName"><strong>Nom</strong></label>
            <input type="text" class="form-control" name="InputName" id="InputName" placeholder="Nom">
          </div>
          <div class="form-group">
            <label for="InputAlias"><strong>Àlies</strong></label>
            <input type="text" class="form-control" name="InputAlias" id="InputAlias" placeholder="Àlies">
          </div>
          <div class="form-group">
            <label for="InputEmail"><strong>e-mail</strong></label>
            <input type="email" class="form-control" name="InputEmail" id="InputEmail" placeholder="exemple@mail.org">
          </div>
          <div class="form-group">
            <label for="InputBdate"><strong>Naixament</strong></label>
            <input type="text" class="form-control" name="InputBdate" id="InputBdate" placeholder="28-02-1990">
          </div>
          <button type="submit" name="create-submit" value="submit" class="btn btn-primary">Envia</button>
          <button type="submit" name="create-desist" value="submit" class="btn btn-primary pull-right">Tanca</button>
        </form>
      </div>
      <div class="col"> </div>
    </div>
  </div>
