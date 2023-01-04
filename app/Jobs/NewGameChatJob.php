<?php

namespace App\Jobs;

use App\Events\SendChatToBot;
use App\Models\ChatLog;
use App\Models\Clan;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 *  This is a new class to replace Apps\Jobs\NewChatHandler
 * @package App\Jobs
 */
class NewGameChatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Clan $clan;
    private array $chat;
    private WebhookService $webhookService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, Array $chat)
    {
        //
        $this->clan = $clan;
        $this->chat = $chat;
        $this->webhookService = new WebhookService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if($this->clan->hasWOMId()){
            RecordCollectionLogJob::dispatch($this->clan, $this->chat);
            PersonalBestJob::dispatch($this->clan, $this->chat);
        }
        $rankOfUser = null;
        if($this->clan->save_chat_logs){
            ChatLog::create([
                'clan_id' => $this->clan->id,
                'message' => $this->chat['message'],
                'sender' => $this->chat['sender'],
            ]);
            $rankOfUser = $this->clan->members()->where('username', $this->chat['sender'])->first()?->rank;
        }
//        broadcast(new SendChatToBot($this->clan, $this->chat));

        $this->webhookService->sendSimpleMessage($this->clan, $this->chat, $rankOfUser);
    }
}
