<?php

namespace App\Jobs;

use App\Models\ChatLog;
use App\Models\Clan;
use App\Models\CollectionLog;
use App\Services\ChatLogPatterns;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordCollectionLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Clan $clan;
    private array $message;

    public function __construct(Clan $clan, array $message)
    {
        $this->clan = $clan;
        $this->message = $message;
    }

    public function handle()
    {
        //
        $collectionLogMatches = [];
        $collectionLogMatch = preg_match(ChatLogPatterns::$collectionLogPattern,
            $this->message['message'], $collectionLogMatches);
        if ($collectionLogMatch != 1) {
            return;
        }
        $rsnMatch = $collectionLogMatches[1];
        $split = explode('/', $collectionLogMatches[2]);
        $runescapeUser = $this->clan->members()->where('username', $rsnMatch)->first();
        if ($runescapeUser) {
            CollectionLog::updateOrCreate(
                [
                    'runescape_users_id' => $runescapeUser->id,
                    'clan_id' => $this->clan->id,
                ],
                [
                    'collection_count' => $split[0]
                ]
            );
        }
    }
}