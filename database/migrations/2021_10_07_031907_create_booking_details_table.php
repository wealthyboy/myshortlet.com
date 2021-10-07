<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->integer('apartment_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('user_id')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('total')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
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
        Schema::dropIfExists('booking_details');
    }
}
