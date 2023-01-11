<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\DropLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DropLogController extends Controller
{
    //
    public function csvOfDropLog(string $confirmationCode, string $startDate, string $endDate)
    {
        $clan = Clan::where('confirmation_code', '=', $confirmationCode)->first();
        if (!$clan) {
            return response(["message" => "A clan was not found for this confirmation code"], 409);
        }

        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $dropLogs = DropLog::where('clan_id', '=', $clan->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
        $csvString = "RSN,Item Name,Quantity,Price,Date" . PHP_EOL;
        foreach ($dropLogs as $dropLog) {
            $csvString .= $dropLog->rsn . "," . $dropLog->item_name . "," . $dropLog->quantity . "," . $dropLog->price . "," . $dropLog->created_at . "\n";
        }
        return response($csvString);
//            ->header('Content-Type', 'text/csv')
//            ->header('Content-Disposition', 'attachment; filename="dropLog.csv"');
    }
}
