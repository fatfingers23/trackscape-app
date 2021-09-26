<?php

namespace App\Jobs;

use App\Models\Clan;
use App\Models\Donation;
use App\Models\RunescapeUser;
use App\Services\WOMService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $justRSNFromWebCall = $this->usersFromWebCall->pluck([$this->wom ? 'username' : 'rsn']);
        $noLongerInClan = $this->clan->members()->pluck('username')->diff($justRSNFromWebCall);
        foreach ($noLongerInClan as $oldClanMate) {
            $nameChange = $this->WOMService->checkForNameChange(strtolower($oldClanMate));
            if ($nameChange) {
                ray("name change: $oldClanMate");
                return;
            }
            $runescapeUser = RunescapeUser::where('username', '=', $oldClanMate)->first();
            ray($runescapeUser);
            Donation::where('runescape_user_id', '=', $runescapeUser->id)->delete();
            $runescapeUser->delete();
        }
    }
}
