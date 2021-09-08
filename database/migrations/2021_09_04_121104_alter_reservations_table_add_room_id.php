<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterReservationsTableAddRoomId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('room_id')->nullable();
            $table->integer('guest_user_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
            $table->integer('number_of_guest')->nullable();
            $table->integer('children')->nullable();
            $table->integer('adults')->nullable();
            $table->boolean('is_active')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('is_active','adults','children','room_id','guest_user_id','quantity','checkin','checkout','number_of_guest');
        });
    }
}
