<?php

namespace App\Services;

use App\Models\ChatLog;
use App\Models\Clan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WebhookService
{

    public function sendSimpleMessage(Clan $clan, ChatLog $chatLog, string $rank = null)
    {
        $webHookUrl = $clan->discord_webhook;
        if ($webHookUrl == null) {
            return;
        }

        $rankLink = "";
        if($rank){
            $upperCaseRank = ucfirst($rank);
            $rankLink = "https://wiseoldman.net/img/runescape/roles/$upperCaseRank.png";
        }
        else if($clan->name == $chatLog->sender){
            $rankLink = "https://oldschool.runescape.wiki/images/Your_Clan_icon.png";
        }
        else{
            $rankLink = "https://oldschool.runescape.wiki/images/Clan_icon_-_Guest.png";
        }

        $body = [
            "username" => $clan->name,
            //Can you translate the bottom from json to a php array?
            "embeds" => [
                [
                    "title" => "",
                    "description" => $chatLog->message,
                    "color" => 0x00FFFF,
                    "timestamp" => Carbon::now('UTC')->toIso8601String(),
                    "author" => [
                        "name" => $chatLog->sender,
                        'icon_url' => $rankLink
                    ]
                ]
            ]
        ];


        Http::post($webHookUrl, $body);
    }

}
