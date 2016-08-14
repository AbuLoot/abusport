<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_option', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id');
            $table->integer('area_id')->references('id')->on('areas');
            $table->integer('option_id')->references('id')->on('options');
            $table->text('text');
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
        Schema::drop('area_option');
    }
}
