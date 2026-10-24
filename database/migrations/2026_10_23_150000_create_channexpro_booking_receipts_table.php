<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannexproBookingReceiptsTable extends Migration
{
    public function up(): void
    {
        Schema::create('channexpro_booking_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('revision_id', 36)->unique();
            $table->string('booking_id', 36)->index();
            $table->string('payload_hash', 64);
            $table->json('response');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('channexpro_booking_receipts');
    }
}
