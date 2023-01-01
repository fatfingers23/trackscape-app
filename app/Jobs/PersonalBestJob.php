<?php

namespace App\Jobs;

use App\Models\Boss;
use App\Models\BossPersonalBest;
use App\Models\Clan;
use App\Services\ChatLogPatterns;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PersonalBestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Clan $clan;
    private array $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, array $message)
    {
        //
        $this->clan = $clan;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $personalBestMatches = [];
        $personalBestMatch = preg_match(ChatLogPatterns::$personalBestPattern,
            $this->message['message'], $personalBestMatches);
        if ($personalBestMatch != 1) {
            return;
        }


        $timeSplit = explode(':', $personalBestMatches[3]);

        $killTime = 0;
        if (count($timeSplit) == 3) {
            $killTime += (intval($timeSplit[0]) * 60) * 60;
            $killTime += intval($timeSplit[1]) * 60;
            $killTime += intval($timeSplit[2]);
        } else {
            $killTime += intval($timeSplit[0]) * 60;
            $killTime += intval($timeSplit[1]);
        }

        $userName = $personalBestMatches[1];
        $bossName = $personalBestMatches[2];
        $runescapeUser = $this->clan->members()->where('username', $userName)->first();

        if ($runescapeUser) {

            $boss = Boss::firstOrCreate(['name' => $bossName]);
            if ($boss) {

                BossPersonalBest::updateOrCreate([
                    'runescape_users_id' => $runescapeUser->id,
                    'clan_id' => $this->clan->id,
                    'bosses_id' => $boss->id
                ], ['kill_time' => $killTime]);
            }

        }
    }

}
