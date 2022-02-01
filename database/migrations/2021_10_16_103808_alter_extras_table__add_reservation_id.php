<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterExtrasTableAddReservationId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extras', function (Blueprint $table) {
            $table->bigInteger('price')->nullable();
            $table->integer('reservation_id')->nullable();
            $table->integer('user_reservation_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extras', function (Blueprint $table) {
            $table->dropColumn('price','reservation_id','user_reservation_id');
        });
    }
}
