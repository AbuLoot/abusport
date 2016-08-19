<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id');
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('field_id')->references('id')->on('fields');
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');
            $table->string('match_type');
            $table->string('game_type');
            $table->integer('number_of_players');
            $table->string('game_format');
            $table->integer('price');
            $table->text('description');
            $table->integer('status')->default(1);
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
        Schema::drop('matches');
    }
}
