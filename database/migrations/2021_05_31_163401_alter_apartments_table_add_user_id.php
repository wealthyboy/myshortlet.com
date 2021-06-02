<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterApartmentsTableAddUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}


SET FOREIGN_KEY_CHECKS=0;


DROP TABLE `ambassadors`, `apartment_attribute`,`attribute_reservation`, `facilities`, `facility_reservation`, `location_reservation`, `requirements`, `reservations`;