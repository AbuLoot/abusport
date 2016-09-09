<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteStreetAndHouseAndAddAddressInTableAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('street');
            $table->dropColumn('house');
            $table->text('phones')->nullable();
            $table->text('emails')->nullable();
            $table->text('address')->nullable();
            $table->text('lang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->dropColumn('phones');
            $table->dropColumn('emails');
            $table->dropColumn('address');
            $table->dropColumn('lang');
        });
    }
}
