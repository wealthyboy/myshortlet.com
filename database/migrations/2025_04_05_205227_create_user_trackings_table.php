<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id');
            $table->string('page_url');
            $table->string('method');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('action')->nullable(); //viewed, clicked, started_checkout, abandoned, etc.
            $table->integer('time_spent')->nullable(); // in seconds
            $table->string('ip_address')->nullable();
            $table->timestamp('visited_at')->nullable();
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
        Schema::dropIfExists('user_trackings');
    }
}
