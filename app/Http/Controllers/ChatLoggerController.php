<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\Clan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ChatLoggerController extends Controller
{
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

        foreach ($requestedJson as $chatLog) {
            if ($chatLog["chatType"] == "CLAN") {
                $messageId = substr($chatLog["id"], 0, -3);
                if (!Cache::has($messageId)) {
                    Cache::put($messageId, $chatLog, $seconds = 10);
                    $newChat = new ChatLog();
                    $newChat->time_sent = Carbon::now('UTC');
//                    $newChat->time_sent = Carbon::parse($chatLog["timestamp"]);
                    $newChat->sender = $chatLog["sender"];
                    $newChat->message = $chatLog["message"];
                    $newChat->clan_id = $clan->id;
                    $newChat->chat_id = $messageId;

                    $newChat->save();
                }
            }
        }
        return response("");
    }

    /**
     * Endpoint to get most recent chat messages
     */
    public function chatLog_get(Request $request, $amount)
    {
        $clan = $request->get('clan');
        $chatLogs = ChatLog::where('clan_id', '=', $clan->id)->distinct()->orderBy('time_sent', 'desc')->take($amount)->get();
        return $chatLogs;
    }
}

