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
            $rankLink = $this->getRankIcon($rank);
        }
        else if($clan->name == $chatLog->sender){
            $rankLink = "https://oldschool.runescape.wiki/images/Your_Clan_icon.png";
        }
        else{
            $rankLink = "https://oldschool.runescape.wiki/images/Clan_icon_-_Guest.png";
        }

        $body = [
            "username" => $clan->name,
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
