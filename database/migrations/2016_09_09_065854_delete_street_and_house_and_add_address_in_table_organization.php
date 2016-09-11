<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteStreetAndHouseAndAddAddressInTableOrganization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('street');
            $table->dropColumn('house');
            $table->text('address')->after('emails')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('street')->nullable();
            $table->string('house')->nullable();
            $table->dropColumn('address');
        });
    }
}
