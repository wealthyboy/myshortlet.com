<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricingSnapshotsToBookingsAndReservations extends Migration
{
    public function up()
    {
        Schema::table('booking_details', function (Blueprint $table) {
            if (! Schema::hasColumn('booking_details', 'currency_code')) {
                $table->string('currency_code', 3)->nullable()->after('regular_price');
            }
            if (! Schema::hasColumn('booking_details', 'currency_symbol')) {
                $table->string('currency_symbol', 10)->nullable()->after('currency_code');
            }
            if (! Schema::hasColumn('booking_details', 'exchange_rate')) {
                $table->decimal('exchange_rate', 18, 6)->nullable()->after('currency_symbol');
            }
            if (! Schema::hasColumn('booking_details', 'pricing_snapshot')) {
                $table->longText('pricing_snapshot')->nullable()->after('exchange_rate');
            }
        });

        Schema::table('user_reservations', function (Blueprint $table) {
            if (! Schema::hasColumn('user_reservations', 'currency_code')) {
                $table->string('currency_code', 3)->nullable()->after('currency');
            }
            if (! Schema::hasColumn('user_reservations', 'exchange_rate')) {
                $table->decimal('exchange_rate', 18, 6)->nullable()->after('currency_code');
            }
            if (! Schema::hasColumn('user_reservations', 'pricing_snapshot')) {
                $table->longText('pricing_snapshot')->nullable()->after('exchange_rate');
            }
        });

        Schema::table('reservations', function (Blueprint $table) {
            if (! Schema::hasColumn('reservations', 'currency_code')) {
                $table->string('currency_code', 3)->nullable();
            }
            if (! Schema::hasColumn('reservations', 'pricing_snapshot')) {
                $table->longText('pricing_snapshot')->nullable();
            }
        });

        // The existing column is an integer, which loses precision for rates
        // such as GBP/EUR. Preserve the exact rate on each reservation line.
        if (Schema::hasColumn('reservations', 'rate')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->decimal('rate', 18, 6)->nullable()->change();
            });
        }
    }

    public function down()
    {
        Schema::table('booking_details', function (Blueprint $table) {
            $columns = array_values(array_filter([
                Schema::hasColumn('booking_details', 'currency_code') ? 'currency_code' : null,
                Schema::hasColumn('booking_details', 'currency_symbol') ? 'currency_symbol' : null,
                Schema::hasColumn('booking_details', 'exchange_rate') ? 'exchange_rate' : null,
                Schema::hasColumn('booking_details', 'pricing_snapshot') ? 'pricing_snapshot' : null,
            ]));

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        Schema::table('user_reservations', function (Blueprint $table) {
            $columns = array_values(array_filter([
                Schema::hasColumn('user_reservations', 'currency_code') ? 'currency_code' : null,
                Schema::hasColumn('user_reservations', 'exchange_rate') ? 'exchange_rate' : null,
                Schema::hasColumn('user_reservations', 'pricing_snapshot') ? 'pricing_snapshot' : null,
            ]));

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        if (Schema::hasColumn('reservations', 'rate')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->integer('rate')->nullable()->change();
            });
        }

        Schema::table('reservations', function (Blueprint $table) {
            $columns = array_values(array_filter([
                Schema::hasColumn('reservations', 'currency_code') ? 'currency_code' : null,
                Schema::hasColumn('reservations', 'pricing_snapshot') ? 'pricing_snapshot' : null,
            ]));

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
}
