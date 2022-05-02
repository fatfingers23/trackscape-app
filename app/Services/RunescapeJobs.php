<?php

namespace App\Services;

use App\Models\ChatLog;
use App\Models\Clan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RunescapeJobs
{
    protected $hiscoreUrl = "https://secure.runescape.com/m=hiscore_oldschool/index_lite.ws?player=";

    public function setLastActiveForAClan(Clan $clan)
    {

        //
        $members = $clan->members()->get();
        foreach ($members as $member) {
            $lastChat = ChatLog::where('sender', $member->username)->latest('created_at')->first();

            if ($lastChat && $lastChat->created_at > $member->last_active) {
                $member->last_active = Carbon::now();
            } else {
                $newActivityHash = $this->hashHiscore($member);
                if ($newActivityHash != "") {
                    if ($newActivityHash != $member->activity_hash) {
                        $member->activity_hash = $newActivityHash;
                        $member->last_active = Carbon::now();
                        $member->save();
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
