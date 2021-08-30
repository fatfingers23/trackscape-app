<?php

namespace Tests\Services;

use App\Models\Clan;
use App\Models\RunescapeUser;
use App\Models\User;
use App\Services\WOMService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WOMServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $baseUrl = "https://api.wiseoldman.net";

    public function test_checkForNameChange()
    {
        $womService = new WOMService();

        $womPlayerId = 123;
        $womGroupId = 456;

        $clan = Clan::factory()->create([
            'name' => 'Some Clan',
            'wom_id' => $womGroupId
        ]);
        $rsn = RunescapeUser::factory()->create([
            'username' => 'clanmember 2',
            'rank' => 'Sapphire',
            'joined_date' => '5-Jul-2021',
            'clan_id' => $clan->id,
            'wom_id' => $womPlayerId
        ]);

        $body = [[
            "oldName" => "clanmember 2",
            "newName" => "new player name",
            "playerId" => $womPlayerId
        ]];

        Http::fake([
            "*" => Http::response($body, 200, ["Accept" => "application/json"])
        ]);

        $womService->checkForNameChange("clanmember 2");
        $user = RunescapeUser::where('wom_id', '=', $womPlayerId)->first();
        ray($user);
        $this->assertEquals('new player name', $user->username);
    }
}
