<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendApartmentDailyRatesForAri extends Migration
{
    public function up()
    {
        Schema::table('apartment_daily_rates', function (Blueprint $table) {
            $table->unsignedInteger('availability')->nullable()->after('sale_price');
            $table->unsignedInteger('min_stay_arrival')->nullable()->after('availability');
            $table->unsignedInteger('min_stay_through')->nullable()->after('min_stay_arrival');
            $table->unsignedInteger('max_stay')->nullable()->after('min_stay_through');
            $table->boolean('closed_to_arrival')->nullable()->after('max_stay');
            $table->boolean('closed_to_departure')->nullable()->after('closed_to_arrival');
            $table->boolean('stop_sell')->nullable()->after('closed_to_departure');
            $table->unique(['apartment_id', 'date'], 'apartment_daily_rates_apartment_date_unique');
        });
    }

    public function down()
    {
        Schema::table('apartment_daily_rates', function (Blueprint $table) {
            $table->dropUnique('apartment_daily_rates_apartment_date_unique');
            $table->dropColumn([
                'availability',
                'min_stay_arrival',
                'min_stay_through',
                'max_stay',
                'closed_to_arrival',
                'closed_to_departure',
                'stop_sell',
            ]);
        });
    }
}
