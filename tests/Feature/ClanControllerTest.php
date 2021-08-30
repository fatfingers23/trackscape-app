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

class ClanControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_signUpClan_post()
    {

        $requestData = [
            'name' => 'Some Clan',
            'discordId' => '123',
            'discordIdOfCreator' => '123',
            'runescapeUserName' => 'KikiIM'
        ];

        $this->actingAs($user = User::factory()->create());

        $response = $this->postJson("/api/clan/signup", $requestData);

        $this->assertAuthenticated();
        $response->assertSuccessful();
        $response->assertJsonStructure(["link"]);

        $clan = Clan::find(1);
        $this->assertNotNull($clan);
        $user = RunescapeUser::where("username", "=", strtolower("KikiIM"))->get();
        $this->assertCount(1, $user);

        $clanAlreadyFoundResponse = $this->postJson("/api/clan/signup", $requestData);
        $clanAlreadyFoundResponse->assertStatus(409);
        $clanAlreadyFoundResponse->assertJsonStructure(["message"]);

    }

    public function test_updateMembers_post()
    {
        $clan = Clan::factory()->create([
            'name' => 'Some Clan'
        ]);
        $confirmationCode = $clan->confirmation_code;

        $requestData = [
            'clanName' => 'Some Clan',
            'clanMemberMaps' => [
                ["rsn" => "Clanmember 1", "rank" => "Sapphire", "joinedDate" => "5-Jul-2021"],
                ["rsn" => "Clanmember 2", "rank" => "Sapphire", "joinedDate" => "4-Jul-2021"]
            ],
        ];

        $response = $this->postJson("/api/clan/$confirmationCode/update/members", $requestData);

        $this->assertFalse($this->isAuthenticated());
        $response->assertSuccessful();
        $members = $clan->members()->get();
        $this->assertCount(2, $members);
    }

    public function test_updateMembersHandleRankChange_post()
    {
        $clan = Clan::factory()->create([
            'name' => 'Some Clan'
        ]);

        $rsn = RunescapeUser::factory()->create([
            'username' => 'Clanmember 2',
            'rank' => 'Sapphire',
            'joined_date' => '5-Jul-2021',
            'clan_id' => $clan->id
        ]);
        $confirmationCode = $clan->confirmation_code;

        $requestData = [
            'clanName' => 'Some Clan',
            'clanMemberMaps' => [
                ["rsn" => "Clanmember 1", "rank" => "Sapphire", "joinedDate" => "5-Jul-2021"],
                ["rsn" => "Clanmember 2", "rank" => "Gnome", "joinedDate" => "4-Jul-2021"]
            ],
        ];

        $response = $this->postJson("/api/clan/$confirmationCode/update/members", $requestData);

        $this->assertFalse($this->isAuthenticated());
        $response->assertSuccessful();
        $members = $clan->members()->get();
        $this->assertCount(2, $members);
        $rankChangedMember = $members->where('username', '=', $rsn->username);
        ray($rankChangedMember);
        $this->assertEquals('Gnome', $rankChangedMember->first()->rank);
    }
}
