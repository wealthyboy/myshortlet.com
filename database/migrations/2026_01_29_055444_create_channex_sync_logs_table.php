<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannexSyncLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channex_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->string('entity_type'); // room_type, rate, availability
            $table->unsignedBigInteger('entity_id');
            $table->string('action'); // create, update
            $table->string('status'); // success, failed
            $table->text('payload')->nullable();
            $table->text('response')->nullable();
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
        Schema::dropIfExists('channex_sync_logs');
    }
}
