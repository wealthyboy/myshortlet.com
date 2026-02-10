<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the unique index
            // $table->dropUnique('invoices_invoice_number_unique');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Restore the unique constraint if rolled back
            //$table->unique('invoice_number');
        });
    }
};
