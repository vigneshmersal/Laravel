<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug');

			$table->string('email')->unique();
			$table->string('phone')->unique()->nullable();
			$table->string('password');

			$table->string('role', 100)->default('patient');
			$table->string('avatar')->nullable();
			$table->string('title');
			$table->text('body');
			$table->integer('salary');

			$table->integer('status')->default(1);

			$table->integer('created_by')->default(1);
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->timestamps();
			$table->datetime('deleted_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
