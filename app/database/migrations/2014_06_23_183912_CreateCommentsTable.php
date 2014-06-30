<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('requirement_id');
      $table->string('body')->nullable();
      $table->string('notes');
      $table->timestamps();

      $table->foreign('requirement_id')->references('id')->on('requirements');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('comments');
	}

}
