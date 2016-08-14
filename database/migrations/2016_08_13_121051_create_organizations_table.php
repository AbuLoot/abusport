<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id');
            $table->integer('country_id')->references('id')->on('countries');
            $table->integer('city_id')->references('id')->on('cities');
            $table->integer('district_id')->references('id')->on('districts');
            $table->integer('org_type_id')->references('id')->on('org_types');
            $table->string('logo');
            $table->string('phones');
            $table->string('website');
            $table->string('emails');
            $table->string('street');
            $table->string('house');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('balance');
            $table->char('lang', 4);
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
        Schema::drop('organizations');
    }
}
