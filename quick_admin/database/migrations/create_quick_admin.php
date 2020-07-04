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
		Schema::create('admins', function(Blueprint $table)
		{
			Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('text');
            $table->longText('textarea')->nullable();
            $table->string('password')->nullable();
            $table->string('radio')->nullable();
            $table->string('select')->nullable();
            $table->boolean('checkbox')->default(0)->nullable();
            $table->integer('integer')->nullable();
            $table->float('float', 8, 2)->nullable();
            $table->decimal('money', 15, 2)->nullable();
            $table->date('date')->nullable();
            $table->datetime('date_time')->nullable();
            $table->time('time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
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
