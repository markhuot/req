<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('user_id');

      /**
       * The parent is the object this notification relates to.
       */
      $table->string('parent');
      $table->unsignedInteger('parent_key');

      /**
       * The initiator is the object that caused this notification to be
       * sent.
       */
      $table->string('initiator');
      $table->unsignedInteger('initiator_key');

      $table->string('notes');
      $table->timestamps();

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
    Schema::dropIfExists('notifications');
  }

}
