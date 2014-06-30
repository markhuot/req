<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHighlightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('highlights', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('comment_id');
      $table->unsignedInteger('user_id');
      $table->string('before')->nullable();
      $table->integer('start');
      $table->string('text');
      $table->integer('end');
      $table->string('after')->nullable();
      $table->timestamps();

      $table->foreign('comment_id')->references('id')->on('comments');
      $table->foreign('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('highlights');
	}

}
