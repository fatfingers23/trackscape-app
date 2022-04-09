<?php

namespace App\Services;

use App\Jobs\GetClansHiscores;
use App\Jobs\RemoveClanMates;
use App\Models\Clan;
use App\Models\Donation;
use App\Models\RunescapeUser;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;

class WOMService
{
    protected $baseUrl = "https://api.wiseoldman.net";

    public function getGroupPlayers($groupId)
    {
        $response = Http::get("$this->baseUrl/groups/$groupId/members");

        if (!$response->successful()) {
            return collect();
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

    public function checkValidGroupId($womId)
    {
        $response = Http::get("$this->baseUrl/groups/$womId");
        return $response->successful();
    }

    public function syncClan(Clan $clan)
    {
        $WOMGroupMembers = $this->getGroupPlayers($clan->wom_id);
        if ($WOMGroupMembers->count() != 0) {
            $this->updateClanMembersFromWOM($WOMGroupMembers, $clan);
        }
        Bus::chain([
            new RemoveClanMates($clan, $WOMGroupMembers, true),
            new GetClansHiscores($clan),
        ])->dispatch();
    }

}
