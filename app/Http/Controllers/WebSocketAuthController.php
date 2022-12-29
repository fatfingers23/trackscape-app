<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\User;
use Illuminate\Http\Request;

class WebSocketAuthController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $user = User::find(1);
        \Auth::login($user);
        \Log::info($user->name);
        return response($user);
        // TODO: Implement __invoke() method.
    }
}
