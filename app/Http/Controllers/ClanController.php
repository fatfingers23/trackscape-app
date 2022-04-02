<?php

namespace App\Http\Controllers;

use App\Jobs\RemoveClanMates;
use App\Models\Clan;
use App\Models\RunescapeUser;
use App\Services\WOMService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\GetClansHiscores;

class ClanController extends Controller
{

    protected $WOMService;

    public function __construct(WOMService $service)
        //i feel)
    {
        //
        $this->WOMService = $service;
    }

    //TODO ADD A GET end point for info
    //
    public function signUpClan_post(Request $request)
    {

        //TODO add validation and re turn 404
        $requestJson = $request->json()->all();

        $clan = Clan::where("name", "=", $requestJson["name"])->first();

        if (!$clan) {
            $clan = Clan::create([
                'name' => $requestJson["name"],
                'discord_server_id' => $requestJson["discordId"],
                'confirmation_code' => uniqid()
            ]);

            $checkForUser = RunescapeUser::where("username", "=", $requestJson["runescapeUserName"])->first();
            if ($checkForUser) {
                $checkForUser->clanId = $clan->id;
                $checkForUser->discordId = $requestJson["discordIdOfCreator"];
                $checkForUser->admin = true;
            } else {

                RunescapeUser::create([
                    "username" => strtolower($requestJson["runescapeUserName"]),
                    "admin" => true,
                    "discord_id" => $requestJson["discordIdOfCreator"],
                    "clan_id" => $clan->id
                ]);
            }

            $url = config("app.url") . "/api/clan/" . $clan->confirmation_code . "/update/members";
            return response(["link" => $url]);
        } else {

            return response(["message" => "The clan {$requestJson["name"]} has already been added."], 409);
        }
    }

    public function updateMembers_post(Request $request, $confirmationCode)
    {
        dd("Broken. is too coupled to wom need to find a change");
        $requestedJson = $request->json()->all();
        $clan = Clan::where('confirmation_code', '=', $confirmationCode)->first();
        if (!$clan) {
            return response(["message" => "The clan has not been setup"], 409);
        }


        $runescapeUsers = array();
        foreach ($requestedJson['clanMemberMaps'] as $runescapeUser) {
            $userInDb = RunescapeUser::where('username', '=', $runescapeUser['rsn'])->first();
            if ($userInDb) {
                if ($userInDb->clan_id != $clan->id) {
                    $userInDb->clan_id = $clan->id;
                    $userInDb->admin = 0;
                }
                if ($userInDb->rank != $runescapeUser['rank']) {
                    $userInDb->rank = $runescapeUser['rank'];
                }
                $userInDb->save();
                array_push($runescapeUsers, $userInDb);
            } else {
                $runescapeUser = RunescapeUser::create([
                    'username' => $runescapeUser['rsn'],
                    'rank' => $runescapeUser['rank'],
                    'joined_date' => Carbon::parse($runescapeUser['joinedDate']),
                    'clan_id' => $clan->id
                ]);
                array_push($runescapeUsers, $runescapeUser);
            }
        }

//        GetClansHiscores::dispatch($clan)->afterResponse();
        RemoveClanMates::dispatch($clan, $requestedJson['clanMemberMaps'], false)->afterResponse();
        return response("");
    }

    public function updateMembersWom_get(Request $request, $discordServerId)
    {
        $clan = Clan::where('discord_server_Id', '=', $discordServerId)->first();
        if (!$clan) {
            return response(["message" => "The clan has not been setup."], 409);
        }
        if ($clan->wom_id == null) {
            return response(["message" => "Wise old man has not been setup for the clan"], 409);
        }


        $WOMGroupMembers = $this->WOMService->getGroupPlayers($clan->wom_id);
        if ($WOMGroupMembers->count() == 0) {
            return response(["message" => "No clanmates found on wiseoldman"], 409);
        }

        $this->WOMService->updateClanMembersFromWOM($WOMGroupMembers, $clan);
        RemoveClanMates::dispatchAfterResponse($clan, $WOMGroupMembers, true);
        //GetClansHiscores::dispatchAfterResponse($clan);

        return response("");

    }

    public function landingPage($clanName)
    {
        $clan = Clan::where('name', $clanName)->first();
        if (!$clan) {
            return response("", 404);
        }

        return view('clan-landing-page',
            [
                'clan' => $clan,
                'collectionLogs' => $clan->collectionLogLeaderBoard()
            ]);
    }
    
}
