<?php

namespace App\Jobs;

use App\Models\Clan;
use App\Models\RunescapeUser;
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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, $usersFromWebCall)
    {
        //
        $this->clan = $clan;
        $this->usersFromWebCall = collect($usersFromWebCall);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
//        ray($justRSNFromWebCall);
        $justRSNFromWebCall = $this->usersFromWebCall->pluck(['rsn']);
        $noLongerInClan = $this->clan->members()->pluck('username')->diff($justRSNFromWebCall);
        foreach ($noLongerInClan as $oldClanMate){
            $runescapeUser = RunescapeUser::where('username', '=', $oldClanMate);
            $runescapeUser->delete();
        }
    }
}
