<?php

namespace App\Jobs;

use App\Models\ChatLog;
use App\Models\Clan;
use App\Services\WebhookService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\ParameterBag;

class NewChatHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Clan $clan;
    protected array $chatLog;
    private WebhookService $webhookService;

    //Hashed version of To talk in your clan's channel, start each line of chat with // or /c.
    private string $hashLoginMessage = "1915cdd2";

    public function __construct(Clan $clan, array $chatLog, WebhookService $webhookService)
    {
        $this->clan = $clan;
        $this->chatLog = $chatLog;
        $this->webhookService = $webhookService;
    }

    public function handle()
    {
        $messageId = substr($this->chatLog["id"], 0, -3);
        $newChat = new ChatLog();
        $newChat->time_sent = Carbon::now('UTC');
//                    $newChat->time_sent = Carbon::parse($chatLog["timestamp"]);
        $newChat->sender = $this->chatLog["sender"];
        $newChat->message = $this->chatLog["message"];
        $newChat->clan_id = $this->clan->id;
        $newChat->chat_id = $messageId;

        $newChat->save();
        $matches = [];
        $match = preg_match('/(.*)received a new collection log item: [^0-9]*(.*)\)$/', $newChat->message, $matches);
        if ($match == 1) {
            RecordCollectionLogJob::dispatch($this->webhookService, $this->clan, $matches);
        }
        $this->webhookService->sendSimpleMessage($this->clan, $newChat);

    }
}