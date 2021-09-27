<?php

namespace App\Console;

use App\Jobs\GetClansHiscores;
use App\Jobs\RemoveClanMates;
use App\Models\Clan;
use App\Services\WOMService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $clans = Clan::all();
            $womService = new WOMService();
            foreach ($clans as $clan) {
                $WOMGroupMembers = $womService->getGroupPlayers($clan->wom_id);
                if ($WOMGroupMembers->count() != 0) {
                    $womService->updateClanMembersFromWOM($WOMGroupMembers, $clan);
                }
                RemoveClanMates::dispatchAfterResponse($clan, $WOMGroupMembers, true);
                GetClansHiscores::dispatchAfterResponse($clan);
            }
        })->everyMinute(); //->twiceDaily("12:00", "23:00");
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
