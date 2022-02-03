<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Invite extends Controller
{
    //

    public function invite($rsn)
    {
        $body = [
            "content" => "$rsn has shared an invite link. If someone joins soon, it's more than likely they were invited by them."
        ];

        Http::post("https://discord.com/api/webhooks/938657310279073802/XCQFlepHIBpe1uxX_3Jn9Cgjyzq-_fuOce-9hd7juQZQPIJRAOU_XNTjzlqsIxanqGrN", $body);

        return redirect("https://discord.gg/56bXKJps");
    }
}
