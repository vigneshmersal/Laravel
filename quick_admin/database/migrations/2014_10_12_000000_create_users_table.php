<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('email', 30)->unique();
            $table->string('password');
            $table->string('mobile', 15)->unique();

            $table->string('employeeid', 30)->nullable();
            $table->date('dob');
            $table->string('profile_image', 30)->nullable();

            $table->date('employee_join_date');
            $table->string('employee_role', 30);
            $table->integer('employee_team');
            $table->text('address');
            $table->string('user_rights', 20);

            $table->integer('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
