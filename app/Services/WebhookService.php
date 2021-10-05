<?php

namespace App\Services;

use App\Models\ChatLog;
use App\Models\Clan;
use Illuminate\Support\Facades\Http;

class WebhookService
{

    public function sendSimpleMessage(Clan $clan, ChatLog $chatLog)
    {
        $webHookUrl = $clan->discord_webhook;
        if ($webHookUrl == null) {
            return;
        }

        $body = [
            "username" => $clan->name,
            "embeds" => [
                [
                    "author" => [
                        "name" => $chatLog->sender
                    ],
                    "description" => $chatLog->message
                ]
            ]
        ];
        Http::post($webHookUrl, $body);
    }

}
