<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunescapeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runescape_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("username", 15);
            $table->boolean("admin")->default(false);
            $table->string("activity_hash", 500)->default("");
            $table->foreignId('clan_id')->constrained();
            $table->date('joined_date')->nullable();
            $table->string("rank", 50)->nullable();
            $table->string("discord_id", 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('runescape_users');
    }
}
