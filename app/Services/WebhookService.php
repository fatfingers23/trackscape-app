<?php

namespace App\Services;

use App\Models\ChatLog;
use App\Models\Clan;
use Illuminate\Support\Facades\Http;

class WebhookService
{

    public function sendSimpleMessage(Clan $clan, array $chat, string $rank = null)
    {
        $webHookUrl = $clan->discord_webhook;
        if ($webHookUrl == null) {
            return;
        }

        $body = [
            "username" => $clan->name,
            //Can you translate the bottom from json to a php array?
            "embeds" => [
                [
                    "title" => "",
                    "description" => $chat['message'],
                    "color" => 0x00FFFF,
                    "author" => [
                        "name" => $chat['sender']
                    ]
                ]
            ]
        ];
        if($rank){
            $upperCaseRank = ucfirst($rank);
            $body['embeds'][0]['author']['icon_url'] = "https://wiseoldman.net/img/runescape/roles/$upperCaseRank.png";
        }

        Http::post($webHookUrl, $body);
    }

}
