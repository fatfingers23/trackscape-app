<?php

namespace App\Services;

use App\Models\Donation;
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

        if ($newNameData) {
            //Temp code to remove some broken name changes
            $this->bugCleanUp($newNameData);

            $user = RunescapeUser::where('wom_id', '=', $newNameData['playerId'])->first();
            if ($user != null) {
                $user->username = $newNameData["newName"];
                $user->save();
                return true;
            }
        }
        return false;
    }


    public function updateClanMembersFromWOM($WOMGroupMembers, $clan)
    {


        //TODO PROBABLY CHANGE THIS TO A SHARED LOGIC WITH ABOVE METHOD
        $runescapeUsers = array();
        foreach ($WOMGroupMembers as $runescapeUser) {
            $userInDb = RunescapeUser::where('username', '=', $runescapeUser['username'])->orWhere('wom_id', '=', $runescapeUser['id'])->first();

            if ($userInDb) {
                if ($userInDb->clan_id != $clan->id) {
                    $userInDb->clan_id = $clan->id;
                    $userInDb->admin = 0;
                }
                if ($userInDb->rank != $runescapeUser['role']) {
                    $userInDb->rank = $runescapeUser['role'];
                }
                $userInDb->wom_id = $runescapeUser['id'];
                $userInDb->save();
                array_push($runescapeUsers, $userInDb);
            } else {

                $runescapeUser = RunescapeUser::create([
                    'username' => $runescapeUser['username'],
                    'rank' => $runescapeUser['role'],
                    'wom_id' => $runescapeUser['id'],
                    'clan_id' => $clan->id
                ]);
                array_push($runescapeUsers, $runescapeUser);
            }
        }

    }


    private function bugCleanUp($newNameData)
    {
        $checkForMistakenNameChange = RunescapeUser::where('wom_id', '=', $newNameData['playerId'])
            ->where('username', '=', $newNameData['newName'])->first();

        if ($checkForMistakenNameChange) {

            $donations = Donation::where('runescape_user_id', '=', $checkForMistakenNameChange->id)->get();
            if ($donations) {
                foreach ($donations as $donation) {
                    $donation->runescape_user_id = $checkForMistakenNameChange->id;
                    $donation->save();
                }
            }

            $checkForMistakenNameChange->delete();
        }
    }
}
