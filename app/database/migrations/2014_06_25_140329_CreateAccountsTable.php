<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function($table)
    {
      $table->increments('id');
      $table->string('name');
      $table->string('subdomain');
      $table->timestamps();
    });

    Schema::create('account_user', function($table)
    {
      $table->increments('id');
      $table->unsignedInteger('account_id');
      $table->unsignedInteger('user_id');
      $table->boolean('pending')->default(true);

      $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('accounts');
    Schema::dropIfExists('account_user');
	}

}
