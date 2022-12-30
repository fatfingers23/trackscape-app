<?php

namespace App\Http\Controllers;

use App\Events\SendChatToGameEvent;
use App\Events\TestBroadCast;
use App\Services\WebsocketConnection;
use App\WebSocketHandler;
use BeyondCode\LaravelWebSockets\Apps\ConfigAppProvider;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager;
use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManagers\ArrayChannelManager;
use BeyondCode\LaravelWebSockets\WebSocketsServiceProvider;
use Illuminate\Http\Request;
use Ratchet\ConnectionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TestEvent extends Controller
{

    /**
     */
    public function __construct()
    {

    }

    public function test (){


        SendChatToGameEvent::dispatch("Insomniacs");

        return response()->json([]);
    }



}
