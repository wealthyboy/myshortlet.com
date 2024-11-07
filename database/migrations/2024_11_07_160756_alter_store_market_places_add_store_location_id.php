<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStoreMarketPlacesAddStoreLocationId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_market_places', function (Blueprint $table) {
            $table->integer('store_location_id')->nullbale();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_market_places', function (Blueprint $table) {
            //
        });
    }
}
