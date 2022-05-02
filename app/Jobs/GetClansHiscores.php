<?php

namespace App\Jobs;

use App\Models\Clan;
use App\Models\RunescapeUser;
use App\Services\RunescapeJobs;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class GetClansHiscores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clan;


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
        $members = $this->clan->members()->get();
        foreach ($members as $member) {
            CheckPlayersActivity::dispatch($member);
        }
    }

}
