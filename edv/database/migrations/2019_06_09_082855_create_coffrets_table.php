<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffrets', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('userId')->unsigned();
            $table->bigInteger('skillId')->unsigned();
            $table->json('vdata');
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('skillId')->references('skillId')->on('skills');
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
        Schema::dropIfExists('coffrets');
    }
}
