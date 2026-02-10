<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvoicesTableAddEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // $table->string('first_name')->nullable();
            // $table->string('last_name')->nullable();
            // $table->string('phone')->nullable();
            // $table->string('email')->nullable();
            // $table->string('address')->nullable();
            // $table->string('state')->nullable();
            // $table->string('country')->nullable();
            // $table->string('invoice_number')->unique();
            // $table->date('invoice_date')->nullable();
            // $table->string('currency', 10)->nullable();
            // $table->decimal('subtotal', 15, 2)->default(0);
            // $table->decimal('discount', 15, 2)->default(0);
            // $table->decimal('caution_fee', 15, 2)->default(0);
            // $table->decimal('tax', 15, 2)->default(0);
            // $table->decimal('total', 15, 2)->default(0);
            // $table->boolean('sent')->default(false);
            // $table->boolean('resent')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
}
