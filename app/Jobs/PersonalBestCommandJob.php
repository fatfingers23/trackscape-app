<?php

namespace App\Jobs;

use App\Models\Boss;
use App\Models\BossPersonalBest;
use App\Models\ChatLog;
use App\Models\RunescapeUser;
use App\Services\RuneliteApiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PersonalBestCommandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $message;
    private RuneliteApiClient $apiClient;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $message)
    {
        //
        $this->message = $message;
        $this->apiClient = new RuneliteApiClient();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $lowerCashMessage = strtolower($this->message['message']);
        $bossName = trim(explode('!pb', $lowerCashMessage)[1]);
        $runescapeUser = RunescapeUser::where('username', $this->message['sender'])->first();
        if ($runescapeUser) {
            $time = $this->apiClient->getUsersPb($this->message['sender'], $bossName);
            if ($time) {
                $bossFullName = $this->apiClient->bossLongName($bossName);
                $boss = Boss::firstOrCreate(['name' => $bossFullName]);
                if ($boss) {
                    BossPersonalBest::updateOrCreate([
                        'runescape_users_id' => $runescapeUser->id,
                        'clan_id' => $runescapeUser->clan_id,
                        'bosses_id' => $boss->id
                    ], ['kill_time' => $time]);
                }
            }
        }

    }
}
