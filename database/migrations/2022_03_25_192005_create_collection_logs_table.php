<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionLogsTable extends Migration
{
    public function up()
    {
        Schema::create('collection_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clan_id')->constrained();
            $table->integer('collection_count');
            $table->foreignId('runescape_users_id')->constrained();

            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collection_logs');
    }
}