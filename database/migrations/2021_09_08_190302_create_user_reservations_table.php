<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('guest_user_id')->nullable();
            $table->integer('property_id')->nullable();
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
            $table->string('currency')->nullable();
            $table->string('msg')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('invoice')->nullable();
            $table->string('total')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('ip')->nullable();
            $table->string('coupon')->nullable();
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
        Schema::dropIfExists('user_reservations');
    }
}
