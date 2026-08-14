<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendChannexRatePlansForMultiplePlans extends Migration
{
    public function up()
    {
        Schema::table('channex_rate_plans', function (Blueprint $table) {
            $table->uuid('channex_rate_plan_id')->nullable()->change();
            $table->decimal('default_rate', 10, 2)->default(0)->after('name');
            $table->string('meal_type', 40)->default('room_only')->after('default_rate');
            $table->boolean('is_active')->default(true)->after('is_default');
            $table->unique(['apartment_id', 'name'], 'channex_rate_plans_apartment_name_unique');
        });

        Schema::table('apartment_daily_rates', function (Blueprint $table) {
            $table->dropUnique('apartment_daily_rates_apartment_date_unique');
            $table->unsignedBigInteger('channex_rate_plan_id')->nullable()->after('apartment_id')->index();
            $table->unique(
                ['apartment_id', 'channex_rate_plan_id', 'date'],
                'apartment_daily_rates_apartment_plan_date_unique'
            );
        });
    }

    public function down()
    {
        Schema::table('apartment_daily_rates', function (Blueprint $table) {
            $table->dropUnique('apartment_daily_rates_apartment_plan_date_unique');
            $table->dropColumn('channex_rate_plan_id');
            $table->unique(['apartment_id', 'date'], 'apartment_daily_rates_apartment_date_unique');
        });

        Schema::table('channex_rate_plans', function (Blueprint $table) {
            $table->dropUnique('channex_rate_plans_apartment_name_unique');
            $table->dropColumn(['default_rate', 'meal_type', 'is_active']);
            $table->uuid('channex_rate_plan_id')->nullable(false)->change();
        });
    }
}
