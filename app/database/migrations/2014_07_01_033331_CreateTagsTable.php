<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tags', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('project_id');
      $table->string('name');
      $table->timestamps();

      $table->foreign('project_id')->references('id')->on('projects');
    });

    Schema::create('requirement_tag', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('requirement_id');
      $table->unsignedInteger('tag_id');

      $table->foreign('requirement_id')->references('id')->on('requirements');
      $table->foreign('tag_id')->references('id')->on('tags');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tags');
  }

}
