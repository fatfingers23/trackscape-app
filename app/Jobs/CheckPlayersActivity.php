<?php

namespace App\Jobs;

use App\Models\ChatLog;
use App\Models\Clan;
use App\Models\RunescapeUser;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckPlayersActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hiscoreUrl = "https://secure.runescape.com/m=hiscore_oldschool/index_lite.ws?player=";

    protected RunescapeUser $runescapeUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RunescapeUser $runescapeUser)
    {
        //
        $this->runescapeUser = $runescapeUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if ($this->runescapeUser->last_active->isToday()) {
            $lastChat = ChatLog::where('sender', $this->runescapeUser->username)->latest('created_at')->first();

            if ($lastChat && $lastChat->created_at > $this->runescapeUser->last_active) {
                $this->runescapeUser->last_active = $lastChat->created_at->toDateString();
                $this->runescapeUser->save();
            } else {
                $newActivityHash = $this->hashHiscore($this->runescapeUser);
                if ($newActivityHash != "") {
                    if ($newActivityHash != $this->runescapeUser->activity_hash) {
                        $this->runescapeUser->activity_hash = $newActivityHash;
                        $this->runescapeUser->last_active = Carbon::now();
                        $this->runescapeUser->save();
                    }
                }
            }
        }
    }


    private function hashHiscore($rsn)
    {
        $response = Http::get($this->hiscoreUrl . $rsn->username);
        if ($response->successful()) {
            $hiscoreDataRaw = $response->body();
            $skillHiscoreCount = 23;
            $hiscoreData = explode("\n", $hiscoreDataRaw);
            $stringToHash = "";

            for ($i = 0; $i <= $skillHiscoreCount; $i++) {
                $skillData = explode(",", $hiscoreData[$i]);
                $stringToHash .= $skillData[1] . $skillData[2];
            }


            $restOfHiscore = array_splice($hiscoreData, $skillHiscoreCount + 1);
            foreach ($restOfHiscore as $item) {
                $splitItem = explode(',', $item);
                if ($item != "") {
                    $stringToHash .= $splitItem[1];
                }

            }
            return md5($stringToHash);
        }
        Log::error("User not found: $rsn->username");
        Log::error("Url called:" . $this->hiscoreUrl . $rsn->username);
        Log::error($response->status());
        return "";
    }
}
