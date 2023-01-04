<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BotController extends Controller
{
    //
    public function getClan(int $discordId){
        $clan = Cache::remember('clan:discordId:' . $discordId, Carbon::now()->addHour(), function () use ($discordId) {
            return Clan::where('discord_server_id', '=', $discordId)->first();
        });
        return response()->json($clan);
    }

}
