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
			$table->id(); // laravel 7
			$table->increments('id'); // tinyIncrements, smallIncrements, mediumIncrements

			$table->char('name', 100); // string('name'), string('slug')

			$table->string('email')->unique();
			$table->string('phone')->unique()->nullable();
			$table->string('password');

			$table->string('title');
			$table->string('image')->nullable();
			$table->string('role', 100)->default('patient');
			$table->text('description'); // mediumText, longText

			$table->integer('salary'); // tinyInteger, smallInteger, mediumInteger, bigInteger
			$table->decimal('price', 8, 2); // unsignedDecimal
			$table->float('amount', 8, 2);
			$table->double('amount', 8, 2);

			$table->rememberToken(); // store token, while logging select "remember me" option
			$table->string('api_token', 60)->unique()->nullable();
			$table->boolean('confirmed');
			$table->integer('status')->default(1);
			$table->unsignedInteger('votes'); // unsignedTinyInteger, unsignedSmallInteger, unsignedMediumInteger, unsignedBigInteger

			$table->date('created_at');
			$table->dateTime('created_at', 0); // dateTimeTz('created_at', 0)

			$table->time('sunrise'); // timeTz()
			$table->year('birth_year');

			$table->geometry('positions');
			$table->ipAddress('visitor');
			$table->macAddress('device');
			$table->point('position');
			$table->uuid('id');
			$table->json('options');

			$table->integer('created_by')->default(1);
			$table->integer('updated_by')->nullable();
			$table->integer('deleted_by')->nullable();

			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent();
			$table->timestamps(); // timestampTz(), timestampsTz()
			$table->datetime('deleted_at')->nullable();
			$table->softDeletes(); // softDeletesTz()

			$table->foreignId('user_id')->index();
			$table->unsignedBigInteger('user_id')->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
