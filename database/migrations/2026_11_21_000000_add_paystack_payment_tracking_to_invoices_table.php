<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaystackPaymentTrackingToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('paystack_reference')->nullable()->unique()->after('payment_info');
            $table->timestamp('paystack_paid_at')->nullable()->after('paystack_reference');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropUnique(['paystack_reference']);
            $table->dropColumn(['paystack_reference', 'paystack_paid_at']);
        });
    }
}
