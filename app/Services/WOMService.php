<?php

namespace App\Services;

use App\Models\Competition;
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

    //TODO just going have them make comp on line then can sync it :)
    public function createCompetition(Competition $competition, $metric, $name)
    {
        $requestToSend = [
            'title' => $competition->donationType()->name,
            ''
        ]
    }
}
