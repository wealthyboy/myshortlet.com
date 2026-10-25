<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoFinderFieldsToImages extends Migration
{
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->string('room_tag', 32)->nullable()->index();
            $table->json('photo_signature')->nullable();
            $table->string('photo_signature_source', 64)->nullable();
            $table->timestamp('photo_indexed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropIndex(['room_tag']);
            $table->dropColumn(['room_tag', 'photo_signature', 'photo_signature_source', 'photo_indexed_at']);
        });
    }
}
