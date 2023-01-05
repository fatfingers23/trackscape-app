<?php

namespace App\Http\Controllers;

use App\Events\SendChatToGame;
use App\Http\Requests\DiscordChatRequest;
use App\Http\Requests\OSRSChatRequest;
use App\Jobs\NewChatHandlerJob;
use App\Jobs\NewGameChatJob;
use App\Models\Clan;
use Carbon\Carbon;
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
        $clanName = $requestData[0]['clanName'];
        $clan = Cache::remember('clan:name:' . $clanName, Carbon::now()->addHour(), function () use ($clanName,) {
            return Clan::where('name', '=', $clanName)->first();
        });

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
        }
        return response()->json([]);
    }

    public function discordChat(DiscordChatRequest $request){
        $request->validated();
        $requestData = $request->all();
        $clan = Cache::remember('clan:discordId:' . $requestData['discord_server'], Carbon::now()->addHour(), function () use ($requestData) {
            return Clan::where('discord_server_id', '=', $requestData['discord_server'])->first();
        });
        if($clan == null){
            return response()->json([]);
        }
        broadcast(new SendChatToGame($clan->name, $requestData['sender'], $requestData['message']));
        return response()->json([]);
    }
}
