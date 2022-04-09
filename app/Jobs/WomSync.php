<?php

namespace App\Jobs;

use App\Models\Clan;
use App\Services\WOMService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WomSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Clan $clan;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan)
    {
        //
        $this->clan = $clan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $womService = new WOMService();
        $womService->syncClan($this->clan);
    }
}
