<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillConfsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('skill_confs', function (Blueprint $table) {
      $table->bigInteger('userId')->unsigned();
      $table->bigInteger('skillId')->unsigned();
      $table->json('vconf');
      $table->timestamps();
      $table->primary(['userId', 'skillId']);
      $table->foreign('userId')->references('id')->on('users');
      $table->foreign('skillId')->references('skillId')->on('skills');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('skill_conf');
  }
}
