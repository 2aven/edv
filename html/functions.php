<?php 

/** This gets a bidimensional array which contains
 * the list of arrays for each Skill with their data.
 * The function prints each Skill in Bootstrap cards
 */
function showSkills($skillList){
  foreach ($skillList as $skillElement) {
    ?>

    <div class="card">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="card-block text-left">
              <h4 class="card-title"><?= $skillElement["nomsk"] ?></h4>
              <form class="form-inline my-auto" method="GET" action="<?= $skillElement['pag']?>">
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
}


?>