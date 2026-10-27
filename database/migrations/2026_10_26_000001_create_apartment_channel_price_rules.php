<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentChannelPriceRules extends Migration
{
    public function up()
    {
        Schema::create('apartment_channel_price_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->constrained()->cascadeOnDelete();
            $table->string('channel', 96);
            $table->decimal('percent', 9, 4)->default(0);
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->timestamps();
            $table->unique(['apartment_id', 'channel']);
        });
    }

    public function down() { Schema::dropIfExists('apartment_channel_price_rules'); }
}
