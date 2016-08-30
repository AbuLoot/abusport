<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->string('title');
            $table->string('size');
            $table->timestamps();
        });

        Schema::create('field_option', function (Blueprint $table) {
            $table->integer('field_id')->references('id')->on('fields');
            $table->integer('option_id')->references('id')->on('options');
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fields');
        Schema::drop('field_option');
        Schema::drop('options');
    }
}
