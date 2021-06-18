<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('booker_first_name')->nullable();
            $table->string('booker_last_name')->nullable();
            $table->string('booker_phone_number')->nullable();
            $table->string('booker_email')->nullable();
            $table->boolean('booker_is_main_guest')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('special_requests')->nullable();
            $table->string('invoice')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('coupon')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('ip')->nullable();
            $table->string('total')->nullable();
            $table->timestamp('arrival_time')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
