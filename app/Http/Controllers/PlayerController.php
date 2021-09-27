<?php

namespace App\Http\Controllers;

use App\Models\RunescapeUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    //
    public function getInactive(Request $request, $days)
    {
        $clan = $request->get('clan');
        $dateToCheckFrom = Carbon::now()->subDays($days)->setHour(0)->setMinutes(0)->setSeconds(0);
        ray($dateToCheckFrom);
        $inactivePlayers = RunescapeUser::where('clan_id', '=', $clan->id)
            ->where('last_active', '<=', $dateToCheckFrom)->get();

        ray($inactivePlayers);
        return response()->json($inactivePlayers);
    }
}
