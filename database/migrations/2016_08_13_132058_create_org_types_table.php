<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id');
            $table->string('slug');
            $table->string('title');
            $table->string('short_title');
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
        Schema::drop('org_types');
    }
}
