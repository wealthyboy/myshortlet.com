<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableApartmentFacilityTableDropForiegnKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartment_facility', function (Blueprint $table) {
            $table->dropForeign(['facility_id']);
            $table->dropForeign(['apartment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartment_facility', function (Blueprint $table) {
            //
        });
    }
}
