<?php

namespace Tests\Feature;

use App\Models\Clan;
use App\Models\RunescapeUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\TestCase;
use Webmozart\Assert\Assert;

class PlayerControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_getInactive()
    {

//        $womPlayerId = 123;
//        $womGroupId = 456;
//
//        $clan = Clan::factory()->create([
//            'name' => 'Some Clan',
//            'wom_id' => $womGroupId
//        ]);
//        $rsn = RunescapeUser::factory()->create([
//            'username' => 'clanmember 2',
//            'rank' => 'Sapphire',
//            'joined_date' => '5-Jul-2021',
//            'clan_id' => $clan->id,
//            'wom_id' => $womPlayerId,
//            'last_active'=>
//        ]);
    }
}
