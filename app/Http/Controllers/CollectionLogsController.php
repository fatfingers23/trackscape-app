<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\CollectionLog;
use Illuminate\Http\Request;

class CollectionLogsController extends Controller
{
    public function index($clanId)
    {
        $clan = Clan::find($clanId);
        if ($clan) {

            return view('collection-log-rank',
                [
                    'clan' => $clan,
                    'collectionLogs' => $clan->collectionLogLeaderBoard()
                ]);
        }

        return abort();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(CollectionLog $collectionLog)
    {
        //
    }

    public function edit(CollectionLog $collectionLog)
    {
        //
    }

    public function update(Request $request, CollectionLog $collectionLog)
    {
        //
    }

    public function destroy(CollectionLog $collectionLog)
    {
        //
    }
}