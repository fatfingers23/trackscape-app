<?php

namespace App\Events;

use App\Models\Clan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Takes chat from the Runeltie plugin and posts to discord, or w/e else
 */
class SendChatToBot implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;
    public Clan $clan;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, $chat)
    {

        $this->chat = $chat;
        $this->clan = $clan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('in-game-chat');
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'game.chat';
    }    //
}
