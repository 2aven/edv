  <!-- Content -->
  <div class="container" id="Skill-list">
      <div class="row text-center">
        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-8 mx-auto">

          <?php
            // funcio-llista-skills ()
            echo "<h1> H E L L O - W O R L D </h1>";
            $skillList = getSkills();
            foreach ($skillList as $skillElement) {
              ?>
          
              <div class="card">
                <div class="container">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card-block text-left">
                        <h4 class="card-title"><?= $skillElement["nomsk"] ?></h4>
                        <form class="form-inline my-auto" method="GET" action="<?= $skillElement['ruta']?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"
                          name='id_skill' value="<?=$skillElement['id']?>">Detall</button>
                        </form>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <img class="card-img-top rounded mx-auto d-block img-thubnail img-fluid" src='<?= $skillElement["imatge"] ?>' alt="<?= $skillElement["name"] ?>">
                    </div>
                  </div>
                </div>
              </div>

            <?php
            }
            ?>
          
        </div>
      </div>

    </div> 
    <!-- END: Skills - container -->
