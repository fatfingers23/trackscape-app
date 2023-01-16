<?php

namespace App\Services;

use App\Jobs\GetClansHiscores;
use App\Jobs\RemoveClanMates;
use App\Models\BossPersonalBest;
use App\Models\Clan;
use App\Models\CollectionLog;
use App\Models\Donation;
use App\Models\RunescapeUser;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class WOMService
{
    protected $baseUrl = "https://api.wiseoldman.net/v2";

    public function getGroupPlayers($groupId)
    {
        $response = Http::get("$this->baseUrl/groups/$groupId");
        if (!$response->successful()) {
            return collect();
        }

        return collect($response->json()['memberships']);
    }

    /**
     *
     * No longer in use. Leaving for now
     * @param $username
     * @param Clan $clan
     * @return bool
     */
    public function checkForNameChange($username, Clan $clan)
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


    /**
     * Updates DB database with WOM group results
     *
     * @param $WOMGroupMembers
     * @param $clan
     * @return void
     */
    public function updateClanMembersFromWOM($WOMGroupMembers, $clan)
    {

        foreach ($WOMGroupMembers as $runescapeUser) {
            try {
                $username = $runescapeUser['player']['username'];
                $userWithRsn = RunescapeUser::where('username', '=', $username)->first();
                if ($userWithRsn) {
                    $userWithRsn->wom_id = $runescapeUser['playerId'];
                    $userWithRsn->rank = $runescapeUser['role'];
                    $userWithRsn->save();
                } else {
                    RunescapeUser::updateOrCreate(
                        [
                            'wom_id' => $runescapeUser['playerId'],
                        ],
                        [
                            'clan_id' => $clan->id,
                            'rank' => $runescapeUser['role'],
                            'username' => $username,
                        ]
                    );
                }

            } catch (Exception $exception) {
                Log::error("Error on updating " . $username . " from wise oldman.");
                throw $exception;
            }


        }

        $womIds = $WOMGroupMembers->pluck('playerId');
        $noLongerInClan = RunescapeUser::whereNotIn('wom_id', $womIds)->get()->pluck('id');
        if ($noLongerInClan) {
            CollectionLog::whereIn('runescape_users_id', $noLongerInClan)->delete();
            BossPersonalBest::whereIn('runescape_users_id', $noLongerInClan)->delete();
            RunescapeUser::whereIn('id', $noLongerInClan)->delete();
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
        GetClansHiscores::dispatch($clan);

    }

}
