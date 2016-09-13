<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLangToOptionsAndFieldsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->char('lang', 4)->after('size');
        });

        Schema::table('options', function (Blueprint $table) {
            $table->char('lang', 4)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->dropColumn('lang');
        });

        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('lang');
        });
    }
}
