<?php

namespace Tests\Feature;

use App\Models\Clan;
use App\Models\RunescapeUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\TestCase;

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
        $this->assertNotNull( $clan);
        $user = RunescapeUser::where("username", "=", "KikiIM")->get();
        $this->assertCount(1, $user);

        $clanAlreadyFoundResponse = $this->postJson("/api/clan/signup", $requestData);
        $clanAlreadyFoundResponse->assertStatus(409);
        $clanAlreadyFoundResponse->assertJsonStructure(["message"]);

    }

    public function test_updateMembers_post()
    {

        $confirmationCode = 121414;
        $requestData = [
            'clanName' => 'Some Clan',
            'clanMemberMaps' => [
                 ["rsn" => "Clanmember 1", "rank" => "Sapphire", "joinedDate" => "5-Jul-2021" ],
                ["rsn" => "Clanmember 2", "rank" => "Sapphire", "joinedDate" => "4-Jul-2021"]
            ],
        ];



        $response = $this->postJson("/api/clan/$confirmationCode/update/members", $requestData);


        $this->assertFalse($this->isAuthenticated());
        $response->assertSuccessful();

    }
}
