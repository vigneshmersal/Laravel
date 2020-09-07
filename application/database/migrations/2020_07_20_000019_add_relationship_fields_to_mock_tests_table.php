<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMockTestsTable extends Migration
{
    public function up()
    {
        Schema::table('mock_tests', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->foreign('category_id', 'category_fk_1833764')->references('id')->on('categories');
        });
    }
}
