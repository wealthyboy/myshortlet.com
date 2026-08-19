<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScenarioToChannexAriOutboxEvents extends Migration
{
    public function up()
    {
        Schema::table('channex_ari_outbox_events', function (Blueprint $table) {
            $table->string('scenario', 60)->nullable()->index()->after('event_type');
        });
    }

    public function down()
    {
        Schema::table('channex_ari_outbox_events', function (Blueprint $table) {
            $table->dropIndex(['scenario']);
            $table->dropColumn('scenario');
        });
    }
}
