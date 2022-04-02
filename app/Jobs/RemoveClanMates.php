<?php

namespace App\Jobs;

use App\Models\BossPersonalBest;
use App\Models\Clan;
use App\Models\CollectionLog;
use App\Models\Donation;
use App\Models\RunescapeUser;
use App\Services\WOMService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RemoveClanMates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $clan;

    protected $usersFromWebCall;

    protected $WOMService;

    protected $wom;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, $usersFromWebCall, $wom)
    {
        //
        $this->clan = $clan;
        $this->usersFromWebCall = collect($usersFromWebCall);
        $this->WOMService = new WOMService();
        $this->wom = $wom;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        Log::info("Remove clan mates job started");

        $justRSNFromWebCall = $this->usersFromWebCall->pluck([$this->wom ? 'username' : 'rsn']);
        $noLongerInClan = $this->clan->members()->pluck('username'); //;

        foreach ($noLongerInClan->diff($justRSNFromWebCall) as $oldClanMate) {
            Log::info("Old clanmate: $oldClanMate");
            $nameChange = $this->WOMService->checkForNameChange(strtolower($oldClanMate));
            if (!$nameChange) {
                $runescapeUser = RunescapeUser::where('username', '=', $oldClanMate)->first();
                Log::info("Deleted: $runescapeUser->username");
                CollectionLog::where('runescape_users_id', $runescapeUser->id)->delete();
                BossPersonalBest::where('runescape_users_id', $runescapeUser->id)->delete();
                $runescapeUser->delete();
            } else {
                Log::info("name change: $oldClanMate");
            }
        }
    }
}
