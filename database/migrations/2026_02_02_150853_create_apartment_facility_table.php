<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('apartment_facility', function (Blueprint $table) {
        //     $table->id();
        //     $table->unique(['apartment_id', 'facility_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration does not own the table. It was created by the
        // 2021_02_26_115125_create_table_apartment_facility migration.
    }
}
