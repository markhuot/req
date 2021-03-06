<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('account_id');
      $table->string('name');
      $table->string('slug');
      $table->timestamps();

      $table->foreign('account_id')->references('id')->on('accounts');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('projects');
	}

}
