<?php

namespace App\Jobs;

use App\Models\Clan;
use App\Models\RunescapeUser;
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

    protected $hiscoreUrl = "https://secure.runescape.com/m=hiscore_oldschool/index_lite.ws?player=";

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan )
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
        $members = $this->clan->members()->get();
        //TODO got to get just xp to make hash of cause rank changes
        ray($members);
        foreach ($members as $member){
            $response = Http::get($this->hiscoreUrl . $member->username);
            if($response->successful()){
                $newActivityHash = md5($response->body());
//                ray($newActivityHash);
//                ray($member->activity_hash);
                if($newActivityHash != $member->activity_hash){
                    $member->activity_hash = $newActivityHash;
                    $member->last_active = Carbon::now();
                    $member->save();
                }
            }
        }
    }
}
