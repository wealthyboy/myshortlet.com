<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToBusinessTables extends Migration
{
    private array $tables = [
        'abandoned_checkouts',
        'apartments',
        'apartment_daily_rates',
        'apartment_stocks',
        'attributes',
        'attribute_prices',
        'booking_details',
        'categories',
        'channex_rate_plans',
        'comments',
        'currencies',
        'currency_rates',
        'currency_rate_countries',
        'extras',
        'facilities',
        'favorites',
        'galleries',
        'guest_users',
        'images',
        'information',
        'invoices',
        'invoice_items',
        'locations',
        'peak_periods',
        'promos',
        'promo_texts',
        'reservations',
        'room_children_attribtes',
        'services',
        'sub_lets',
        'users',
        'user_reservations',
        'videos',
        'vouchers',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'deleted_at')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->softDeletes();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'deleted_at')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropSoftDeletes();
            });
        }
    }
}