<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\RunescapeUser;
use Illuminate\Http\Request;

class ClanController extends Controller
{
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

            $url = config("app.url") . "/api/clan/" . $clan->confirmation_code . "update/members";
            return response(["link" => $url]);
        }else{

            return response(["message" => "The clan {$requestJson["name"]} has already been added."], 409);
        }
    }

    public function updateMembers_post(Request $request, $confirmationCode){

        $requestedJson = $request->json()->all();
        ray($confirmationCode);
        ray($requestedJson);
    }

}
