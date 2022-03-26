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
    protected ParameterBag $chatFromRequest;
    private WebhookService $webhookService;

    //Hashed version of To talk in your clan's channel, start each line of chat with // or /c.
    private string $hashLoginMessage = "1915cdd2";

    public function __construct(Clan $clan, ParameterBag $chatFromRequest, WebhookService $webhookService)
    {
        $this->clan = $clan;
        $this->chatFromRequest = $chatFromRequest;
        $this->webhookService = $webhookService;
    }

    public function handle()
    {
        //
        foreach ($this->chatFromRequest as $chatLog) {
            if ($chatLog["chatType"] == "CLAN") {
                $messageId = substr($chatLog["id"], 0, -3);
                $stringToHash = $chatLog["sender"] . $chatLog['message'];
                $messageHash = hash('crc32c', $stringToHash);
                if ($messageHash !== $this->hashLoginMessage) {
                    if (!Cache::has($messageHash)) {
                        Cache::put($messageHash, $chatLog, $seconds = 10);
                        $newChat = new ChatLog();
                        $newChat->time_sent = Carbon::now('UTC');
//                    $newChat->time_sent = Carbon::parse($chatLog["timestamp"]);
                        $newChat->sender = $chatLog["sender"];
                        $newChat->message = $chatLog["message"];
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
            }
        }
    }
}