<?php

namespace Tests\Feature;

use App\Models\Clan;
use App\Models\DonationType;
use App\Models\RunescapeUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Tests\TestCase;
use Webmozart\Assert\Assert;

class DonationsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function setupData()
    {

        $clan = Clan::factory()->create([
            'name' => 'Some Clan',
            'discord_server_id' => '123'
        ]);

        $rsn = RunescapeUser::factory()->create([
            'username' => 'Clanmember 2',
            'rank' => 'Sapphire',
            'joined_date' => '5-Jul-2021',
            'clan_id' => $clan->id,
            'discord_id' => '456',
            'admin' => 1
        ]);

        $headers = [
            'userdiscordid' => $rsn->discord_id,
            'discordserverid' => $clan->discord_server_id
        ];

        $donationType = new DonationType();
        $donationType->name = "SOTW";
        $donationType->clan_id = $clan->id;
        $donationType->save();

        return [
            'clan' => $clan,
            'rsn' => $rsn,
            'headers' => $headers
        ];
    }


    public function test_addDonation_with_decimal_post()
    {
        ray()->showRequests();
        $setUp = $this->setupData();

        $requestData = [
            'amount' => '2.5m',
            'donationType' => 'SOTW',
            'username' => $setUp['rsn']->username
        ];

        $this->actingAs($user = User::factory()->create());

        $response = $this->withHeaders($setUp['headers'])->postJson("/api/donations/add/donation", $requestData);

        $this->assertAuthenticated();
        $response->assertSuccessful();
        $this->assertEquals('2,500,000', $response->json('total'));

    }

    public function test_addDonation_with_int_post()
    {
        ray()->showRequests();
        $setUp = $this->setupData();

        $requestData = [
            'amount' => '2m',
            'donationType' => 'SOTW',
            'username' => $setUp['rsn']->username
        ];

        $this->actingAs($user = User::factory()->create());

        $response = $this->withHeaders($setUp['headers'])->postJson("/api/donations/add/donation", $requestData);

        $this->assertAuthenticated();
        $response->assertSuccessful();
        $this->assertEquals('2,000,000', $response->json('total'));

    }

    public function test_addDonation_with_k_post()
    {
        ray()->showRequests();
        $setUp = $this->setupData();

        $requestData = [
            'amount' => '550k',
            'donationType' => 'SOTW',
            'username' => $setUp['rsn']->username
        ];

        $this->actingAs($user = User::factory()->create());

        $response = $this->withHeaders($setUp['headers'])->postJson("/api/donations/add/donation", $requestData);

        $this->assertAuthenticated();
        $response->assertSuccessful();
        $this->assertEquals('550,000', $response->json('total'));

    }


}
