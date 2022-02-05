<?php

namespace App\Http\Controllers;

use App\Models\RunescapeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Invite extends Controller
{
    //

    public function invite($rsn)
    {

        $redirectUrl = "https://discord.gg/PWy8pm782p";

        if (!$rsn) {
            return redirect($redirectUrl);
        }

        $playerInDb = RunescapeUser::where('username', '=', $rsn)->get()->first();

        if (!$playerInDb) {
            abort(404);
        }

        $body = [
            "content" => $playerInDb->username . " has shared an invite link. If someone joins soon, it's more than likely they were invited by them."
        ];

        Http::post("https://discord.com/api/webhooks/938657310279073802/XCQFlepHIBpe1uxX_3Jn9Cgjyzq-_fuOce-9hd7juQZQPIJRAOU_XNTjzlqsIxanqGrN", $body);

        return redirect($redirectUrl);
    }
}
