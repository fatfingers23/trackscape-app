<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drop_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('rsn');
            $table->string('item_name');
            $table->integer('quantity')->default(1);
            $table->integer('price');
            $table->foreignId('clan_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drop_logs');
    }
};
