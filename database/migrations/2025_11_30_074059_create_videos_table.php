<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            // Polymorphic relationship
            $table->unsignedBigInteger('videoable_id');
            $table->string('videoable_type')->nullable();

            // Video details
            $table->string('filename')->nullable();
            $table->string('path')->nullable();
            $table->string('encoded_path')->nullable();
            $table->boolean('encoded')->default(false);

            $table->timestamps();

            // Optional index for performance
            $table->index(['videoable_id', 'videoable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
