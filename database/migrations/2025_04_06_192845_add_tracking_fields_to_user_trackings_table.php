<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrackingFieldsToUserTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_trackings', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('code')->nullable();
            $table->string('phone_number')->nullable();
            $table->json('services')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->unsignedBigInteger('booking_ids')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->string('coupon')->nullable();
            $table->json('property_services')->nullable();
            $table->decimal('original_amount', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_trackings', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'email',
                'code',
                'phone_number',
                'services',
                'currency',
                'total',
                'booking_ids',
                'property_id',
                'coupon',
                'property_services',
                'original_amount',
            ]);
        });
    }
}
