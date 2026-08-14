<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannexRevisionFieldsToUserReservations extends Migration
{
    public function up()
    {
        Schema::table('user_reservations', function (Blueprint $table) {
            $table->string('external_id')->nullable()->index();
            $table->string('ota_name')->nullable();
            $table->uuid('channex_last_revision_id')->nullable()->index();
            $table->timestamp('channex_last_revision_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('user_reservations', function (Blueprint $table) {
            $table->dropIndex(['external_id']);
            $table->dropIndex(['channex_last_revision_id']);
            $table->dropColumn([
                'external_id',
                'ota_name',
                'channex_last_revision_id',
                'channex_last_revision_at',
            ]);
        });
    }
}
