<?php

namespace App\Console\Commands;

use App\Jobs\GetClansHiscores;
use App\Jobs\RemoveClanMates;
use App\Models\Clan;
use App\Services\WOMService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class WomSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wom:sync {clanid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $clanId = $this->argument('clanid');

        $clan = Clan::find($clanId);
        if (!$clan) {
            return 1;
        }
        $womService = new WOMService();

        $WOMGroupMembers = $womService->getGroupPlayers($clan->wom_id);
        if ($WOMGroupMembers->count() != 0) {
            $womService->updateClanMembersFromWOM($WOMGroupMembers, $clan);
        }
        Bus::chain([
            new RemoveClanMates($clan, $WOMGroupMembers, true),
            new GetClansHiscores($clan),
        ])->dispatch();


        return 0;
    }
}
