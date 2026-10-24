<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnsureCurrencyColumnOnReservationsTable extends Migration
{
    public function up()
    {
        // The legacy migration guarded both columns with apartment_id. A table
        // that already had apartment_id could therefore be left without currency.
        if (! Schema::hasColumn('reservations', 'currency')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('currency')->nullable();
            });
        }
    }

    public function down()
    {
        // Corrective, additive migration: never remove an existing column or
        // discard currency values saved by successful reservations on rollback.
    }
}
