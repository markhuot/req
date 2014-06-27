<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('teams', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('account_id');
      $table->string('name');
      $table->timestamps();

      $table->foreign('account_id')->references('id')->on('accounts');
    });

    Schema::create('team_user', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('team_id');
      $table->unsignedInteger('user_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('teams');
    Schema::dropIfExists('team_user');
  }

}
