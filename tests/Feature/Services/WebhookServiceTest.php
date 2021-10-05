<?php

namespace Tests\Feature\Services;

use App\Models\ChatLog;
use App\Models\Clan;
use App\Services\WebhookService;
use Tests\TestCase;

class WebhookServiceTest extends TestCase
{

    public function test_sendSimpleMessage()
    {
        $clan = new Clan();
        $clan->discord_webhook = "";
        $clan->name = "Insomniacs";
        $chat = new ChatLog();
        $chat->sender = "FatFingersIM";
        $chat->message = "Git Gud N00bs";
        $webhookService = new WebhookService();
        $webhookService->sendSimpleMessage($clan, $chat);

    }

}
