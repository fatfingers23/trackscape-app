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
        //TODO also need to do a check for users active before the date. this doesnt seem to do that. So only shows records innetweem
        //today and x amount of days ago
        $clan = $request->get('clan');
        $dateToCheckFrom = Carbon::now()->subDays($days)->setHour(0)->setMinutes(0)->setSeconds(0);
        $inactivePlayers = RunescapeUser::where('clan_id', '=', $clan->id)
            ->where('last_active', '<=', $dateToCheckFrom)->orderBy('username', 'desc')->get();

        return response()->json($inactivePlayers);
    }
}
