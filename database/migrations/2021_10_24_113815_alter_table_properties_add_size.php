<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePropertiesAddSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('size')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('toilets')->nullable();
            $table->boolean('is_land')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('size','bedrooms','toilets','is_price_negotiable','is_land');
        });
    }
}
