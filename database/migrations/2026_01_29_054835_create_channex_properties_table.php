<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannexPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channex_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id'); // your local property
            $table->uuid('channex_property_id')->unique();
            $table->uuid('channex_group_id')->nullable();
            $table->string('currency')->default('NGN');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('channex_properties');
    }
}
