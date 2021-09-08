<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Services\WOMService;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    //
    protected $womService;

    public function __construct(WOMService $WOMService)
    {
        $this->womService = $WOMService;
    }


    public function syncCompetition_post(Request $request)
    {
        $requestData = $request->json();
        $clan = $request->get('clan');

        $womSyncResponse = $this->womService->linkCompetition($requestData["compId"], $clan->id);
        if (!$womSyncResponse) {
            return response(["message" => "There was an issue adding this competition. Double check id."], 409);
        } else {
            return response(["link" => "link"]);
        }
    }

    public function confirmationCode_get($clanConfirmationCode, $compId)
    {
        $clan = Clan::where('confirmation_code', '=', $clanConfirmationCode)->first();


        return view('confirmation-code', ['clan' => $clan]);
    }

}
