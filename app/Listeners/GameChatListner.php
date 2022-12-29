<?php

namespace App\Listeners;

use App\Events\SendChatToGameEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GameChatListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendChatToGameEvent  $event
     * @return void
     */
    public function handle(SendChatToGameEvent $event)
    {
        //
        ray($event);
    }
}
