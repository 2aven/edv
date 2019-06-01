<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('skills', function (Blueprint $table) {
      $table->bigIncrements('skillId');
//      $table->string('name', 191);  // The index key prefix length limit is 767 bytes for InnoDB tables that use the REDUNDANT or COMPACT row format. Assuming a utf8mb4 character set and the maximum of 4 bytes for each character: 191 * 4 = 764 (works).
      $table->string('slug', 24)->unique();   // Used as a construction parameter for 'route' and 'image'
      $table->json('vparam');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('skills');
  }
}
