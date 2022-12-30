<?php

namespace App\Http\Controllers;

use App\Events\SendChatToGameEvent;
use App\Http\Requests\OSRSChatRequest;
use Illuminate\Http\Request;

/**
 *
 * This endpoint differs from Chatlog in the fact that it will replace it and uses our own plugin
 */
class ChatController extends Controller
{
    //

    public function osrsChat(OSRSChatRequest $request){
        $request->validated();
        foreach ($request->all() as $message){
            broadcast(new SendChatToGameEvent($message['clanName'], $message['sender'], $message['message']))->toOthers();
        }


        return response()->json([]);
    }
}
