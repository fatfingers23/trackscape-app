<?php

namespace App\Http\Controllers;

use App\Jobs\NewChatHandlerJob;
use App\Models\ChatLog;
use App\Models\Clan;
use App\Services\WebhookService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatLoggerController extends Controller
{

    protected $webhookService;
    //Hashed version of To talk in your clan's channel, start each line of chat with // or /c.
    private string $hashLoginMessage = "1915cdd2";

    public function __construct(WebhookService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * End point to save a chat messaege from in game
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function chatLog_post(Request $request)
    {
        $lookUpClanId = $request->header('Authorization');

        $clan = Clan::where('confirmation_code', '=', $lookUpClanId)->first();
        if (!$clan) {
            return response(["message" => "A clan was not found for this confirmation code"], 409);
        }

        $requestedJson = $request->json();
        foreach ($requestedJson as $requestedChat) {
            if ($requestedChat["chatType"] == "CLAN" && strtolower($requestedChat["chatName"]) == strtolower($clan->name)) {
                $stringToHash = $requestedChat["sender"] . $requestedChat['message'];
                $messageHash = hash('crc32c', $stringToHash);
//                ray($request);
                if ($this->hashLoginMessage !== $messageHash) {
                    if (!Cache::has($messageHash)) {
                        Cache::put($messageHash, $requestedChat, $seconds = 10);
                        NewChatHandlerJob::dispatch($clan, $requestedChat, $this->webhookService);
                    }
                }
            }
        }

        return response("");
    }

}

