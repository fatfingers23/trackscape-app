<?php

namespace App\Services;

use App\Models\ChatLog;
use App\Models\Clan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class WebhookService
{

    public function sendSimpleMessage(Clan $clan, array $chat, string $rank = null)
    {
        $webHookUrl = $clan->discord_webhook;
        if ($webHookUrl == null) {
            return;
        }


        $rankLink = "";
        if($rank){
            $rankLink = $this->getRankIcon($rank);
        }
        else if($clan->name == $chat['sender']){
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
                    "description" => $chat['message'],
                    "color" => 0x00FFFF,
                    "timestamp" => Carbon::now('UTC')->toIso8601String(),
                    "author" => [
                        "name" => $chat['sender'],
                        "icon_url" => $rankLink
                    ]
                ]
            ]
        ];

        Http::post($webHookUrl, $body);
    }

    private function getRankIcon(string $rank){
        $wikiPrefix = "https://oldschool.runescape.wiki/images/Clan_icon_-_";
        if ($rank == trim($rank) && str_contains($rank, ' ')) {
            $rankSplit = explode(" ", $rank);
            $newRank = "";
            foreach ($rankSplit as $split){
                $newRank .= ucfirst($split) . "_";
            }
            $rankIconName = substr($newRank, 0, -1);
            return $wikiPrefix . $rankIconName . ".png";
        }
        $upperCaseRank = ucfirst($rank);
        return $wikiPrefix . $upperCaseRank . ".png";
    }
}
