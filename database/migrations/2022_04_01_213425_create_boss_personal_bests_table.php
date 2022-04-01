<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBossPersonalBestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boss_personal_bests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('clan_id')->constrained();
            $table->foreignId('bosses_id')->constrained();
            $table->foreignId('runescape_users_id')->constrained();
            $table->integer('kill_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boss_personal_bests');
    }
}
