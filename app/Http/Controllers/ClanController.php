<?php

namespace App\Http\Controllers;

use App\Jobs\RemoveClanMates;
use App\Models\Clan;
use App\Models\RunescapeUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\GetClansHiscores;

class ClanController extends Controller
{

    //TODO ADD A GET end point for info
    //
    public function signUpClan_post(Request $request){

        //TODO add validation and re turn 404
        $requestJson = $request->json()->all();

        $clan = Clan::where("name", "=", $requestJson["name"])->first();

        if(!$clan){
            $clan = Clan::create([
                'name' => $requestJson["name"],
                'discord_server_id' => $requestJson["discordId"],
                'confirmation_code' => uniqid()
            ]);

            $checkForUser = RunescapeUser::where("username", "=", $requestJson["runescapeUserName"])->first();
            if($checkForUser){
                $checkForUser->clanId = $clan->id;
                $checkForUser->discordId = $requestJson["discordIdOfCreator"];
                $checkForUser->admin = true;
            }else{

                RunescapeUser::create([
                    "username" => $requestJson["runescapeUserName"],
                    "admin" => true,
                    "discord_id" => $requestJson["discordIdOfCreator"],
                    "clan_id" => $clan->id
                ]);
            }

            $url = config("app.url") . "/api/clan/" . $clan->confirmation_code . "/update/members";
            return response(["link" => $url]);
        }else{

            return response(["message" => "The clan {$requestJson["name"]} has already been added."], 409);
        }
    }

    public function updateMembers_post(Request $request, $confirmationCode){

        $requestedJson = $request->json()->all();
        $clan = Clan::where('confirmation_code', '=', $confirmationCode)->first();
        if(!$clan){
            return response(["message" => "The clan has not been setup"], 409);
        }

        $runescapeUsers = array();
        foreach ($requestedJson['clanMemberMaps'] as $runescapeUser){
            $userInDb = RunescapeUser::where('username', '=', $runescapeUser['rsn'])->first();
            if($userInDb){
                if($userInDb->clan_id != $clan->id){
                    $userInDb->clan_id = $clan->id;
                    $userInDb->admin = 0;
                }
                if($userInDb->rank != $runescapeUser['rank']){
                    $userInDb->rank = $runescapeUser['rank'];
                }
                $userInDb->save();
                array_push($runescapeUsers, $userInDb);
            }else{
                $runescapeUser = RunescapeUser::create([
                    'username' => $runescapeUser['rsn'],
                    'rank'=> $runescapeUser['rank'],
                    'joined_date' => Carbon::parse($runescapeUser['joinedDate']),
                    'clan_id' => $clan->id
                ]);
                array_push($runescapeUsers, $runescapeUser);
            }
        }

//        GetClansHiscores::dispatch($clan)->afterResponse();
        RemoveClanMates::dispatch($clan, $requestedJson['clanMemberMaps'])->afterResponse();
        return response("");
    }

}
