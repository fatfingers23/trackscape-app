<?php

namespace App\Jobs;

use App\Models\ChatLog;
use App\Models\Clan;
use App\Models\CollectionLog;
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
    private WebhookService $webhookService;
    private array $matches;

    public function __construct(WebhookService $webhookService, Clan $clan, array $matches)
    {
        $this->clan = $clan;
        $this->webhookService = $webhookService;
        $this->matches = $matches;
    }

    public function handle()
    {
        //
        $rsnMatch = $this->matches[1];
        $split = explode('/', $this->matches[2]);
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