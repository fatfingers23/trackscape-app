<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RunescapeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("runescape_users")->insert([
            'username' => 'FatFingersIM',
            'admin' => true,
            'activity_hash' => '098f6bcd4621d373cade4e832627b4f6',
            'joined_date' => Carbon::today(),
            'rank' => 'Deputy Owner',
            'clan_id' => 1
        ]);
    }
}
