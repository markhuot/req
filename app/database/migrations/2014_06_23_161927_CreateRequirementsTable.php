<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('requirements', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('project_id');
      $table->string('title')->nullable();
      $table->string('body');
      $table->string('status')->default('pending');
      $table->timestamps();

      $table->foreign('project_id')->references('id')->on('projects');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('requirements');
  }

}
