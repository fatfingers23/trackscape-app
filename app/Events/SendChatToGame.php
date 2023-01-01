<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class SendChatToGame
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $clanName;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($clanName, $sender, $message)
    {
        //
        $this->clanName = $clanName;
        $this->sender = $sender;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('clan-chat-channel.' . $this->clanName);
    }

    public function broadcastAs()
    {
        return 'discord.chat';
    }
}
