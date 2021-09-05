<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DonationTypesComp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('donation_types', function (Blueprint $table) {
            //
            $table->foreignId('competitions_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('donation_types', function (Blueprint $table) {
            //
            $table->dropColumn('competitions_id');
        });
    }
}
