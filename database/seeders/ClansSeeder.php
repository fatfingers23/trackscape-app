<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("clans")->insert([
            'name' => 'My Clan',
            'discord_server_id' => '123',
            'confirmation_code' => '5bdd0b74e9a6c'
        ]);
    }
}
