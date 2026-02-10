<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendFacilitiesForChannex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilities', function (Blueprint $table) {

            // Optional description
            $table->text('description')->nullable()->after('name');

            // Scope of the facility
            $table->string('scope')
                ->default('room');

            // Channex mapping
            $table->string('channex_facility_id')
                ->nullable();



            $table->string('channex_kind')
                ->nullable();


            // Enable/disable toggle
            $table->boolean('is_active')
                ->default(true);


            $table->string('ota_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
