<?php

namespace App\Services;

use App\Models\Competition;
use App\Models\DonationType;
use App\Models\RunescapeUser;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class WOMService
{
    protected $baseUrl = "https://api.wiseoldman.net";

    public function getGroupPlayers($groupId)
    {
        $response = Http::get("$this->baseUrl/groups/$groupId/members");

        if (!$response->successful()) {
            return [];
        }

        return collect($response->json());
    }

    public function checkForNameChange($username)
    {
        $response = Http::get("$this->baseUrl/names?username=$username&status=2");

        if (!$response->successful()) {
            return false;
        }

        $nameChanges = collect($response->json());
        if ($nameChanges->count() == 0) {
            return false;
        }

        $newNameData = $nameChanges->where('oldName', '=', $username)->sortBy('resolvedAt')->first();
        ray($newNameData);
        $user = RunescapeUser::where('wom_id', '=', $newNameData['playerId'])->first();

        if ($user != null) {
            $user->username = $newNameData["newName"];
            $user->save();
            return true;
        }

        return false;
    }

    public function getCompetition($compId)
    {
        $response = Http::get("$this->baseUrl/competitions/$compId");
        if (!$response->successful()) {
            return null;
        }

        return $response->json();
    }

    //TODO just going have them make comp on line then can sync it :)
    //https://wiseoldman.net/docs/competitions
    //Make a html page for people to enter conifmation code once comp as been linked
    public function linkCompetition($compId, $clanId)
    {

        $responseData = $this->getCompetition($compId);
        if ($responseData == null) {
            return false;
        }

        if ($responseData['type'] == 'team') {
            //TODO not implemented yet
            return false;
        }

        $newDonationType = new DonationType();
        $newDonationType->name = $responseData['title'];
        $newDonationType->clan_id = $clanId;
        $newDonationType->save();

        $newCompetition = new Competition();
        $newCompetition->wom_comp_id = $responseData['id'];
        $newCompetition->clan_id = $clanId;
        $newCompetition->donation_type_id = $newDonationType->Id;
        $newCompetition->save();
        return true;
    }
}
