<?php

namespace App\Http\Controllers;

use App\Http\Requests\OSRSChatRequest;
use App\Jobs\NewChatHandlerJob;
use App\Jobs\NewGameChatJob;
use App\Models\Clan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 *
 * This endpoint differs from Chatlog in the fact that it will replace it and uses our own plugin
 */
class ChatController extends Controller
{
    //

    public function osrsChat(OSRSChatRequest $request){
        $request->validated();
        $requestData = $request->all();
        $clan = Clan::where('name', '=', $requestData[0]['clanName'])->first();
        if($clan == null){
            return response()->json([]);
        }
        foreach ($requestData as $message){
            $stringToHash = $message["sender"] . $message['message'];
            $messageHash = hash('crc32c', $stringToHash);
            if (!Cache::has($messageHash)) {
                ray($message);
                Cache::put($messageHash, $message, $seconds = 10);
                NewGameChatJob::dispatch($clan, $message);
            }
//                broadcast(new SendChatToGameEvent($message['clanName'], $message['sender'], $message['message']))->toOthers();
        }


        return response()->json([]);
    }
}
