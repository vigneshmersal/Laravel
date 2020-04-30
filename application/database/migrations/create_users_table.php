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

			$table->unsignedInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

			$table->string('email')->unique();
			$table->string('phone')->unique()->nullable();
			$table->string('password');
			$table->string('remember_token'); // store token, while logging select "remember me" option

			$table->string('role', 100)->default('patient');
			$table->string('avatar')->nullable();
			$table->string('title');
			$table->text('body');
			$table->integer('salary');
			$table->decimal('price');
			$table->text('description');

			// API
			$table->string('api_token', 60)->unique()->nullable();

			$table->integer('status')->default(1);

			$table->integer('created_by')->default(1);
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();
			$table->timestamps();
			$table->datetime('deleted_at')->nullable();

			$table->primary(['user_id']); // change primary key of the table
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
