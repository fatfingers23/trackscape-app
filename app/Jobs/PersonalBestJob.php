<?php

namespace App\Jobs;

use App\Models\Boss;
use App\Models\BossPersonalBest;
use App\Models\Clan;
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
    private array $matches;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, array $matches)
    {
        //
        $this->clan = $clan;
        $this->matches = $matches;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        $timeSplit = explode(':', $this->matches[3]);

        $killTime = intval($timeSplit[0]) * 60;
        $killTime += intval($timeSplit[1]);
        $userName = $this->matches[1];
        $bossName = $this->matches[2];
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
