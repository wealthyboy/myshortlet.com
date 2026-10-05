<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceMailDeliveryTrackingToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_mail_status', 40)->nullable()->after('resent');
            $table->string('invoice_mail_client_reference', 191)->nullable()->after('invoice_mail_status');
            $table->string('zeptomail_request_id', 255)->nullable()->after('invoice_mail_client_reference');
            $table->string('zeptomail_email_reference', 255)->nullable()->after('zeptomail_request_id');
            $table->timestamp('invoice_mail_sent_at')->nullable()->after('zeptomail_email_reference');
            $table->timestamp('invoice_delivered_at')->nullable()->after('invoice_mail_sent_at');
            $table->timestamp('invoice_mail_checked_at')->nullable()->after('invoice_delivered_at');
            $table->text('invoice_mail_last_error')->nullable()->after('invoice_mail_checked_at');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_mail_status',
                'invoice_mail_client_reference',
                'zeptomail_request_id',
                'zeptomail_email_reference',
                'invoice_mail_sent_at',
                'invoice_delivered_at',
                'invoice_mail_checked_at',
                'invoice_mail_last_error',
            ]);
        });
    }
}
