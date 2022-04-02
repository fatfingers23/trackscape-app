<?php

namespace App\Http\Controllers;

use App\Models\Boss;
use App\Models\Clan;

class PbController extends Controller
{
    public function index($clanId)
    {
        $clan = Clan::find($clanId);
        if (!$clan) {
            return response("", 404);
        }

        $pbs = Boss::with(['Pbs' => function ($query) use ($clanId) {
            return $query->with('player')->where('clan_id', $clanId)->orderBy('kill_time');
        }])->orderBy('name')->get();

        return view('pb-leader-board',
            [
                'clan' => $clan,
                'pbs' => $pbs
            ]);
    }
}