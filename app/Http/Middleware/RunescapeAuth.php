<?php

namespace App\Http\Middleware;

use App\Models\Clan;
use App\Models\RunescapeUser;
use Closure;
use Illuminate\Http\Request;

class RunescapeAuth
{

    public $clan;
    public $runescapeUserMakingRequest;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $discordUserId = $request->header('userdiscordid');
        $discordServerId = $request->header('discordserverid');

        if (!$discordServerId || !$discordUserId) {
            return response(["message" => "Proper auth headers have not been set"], 401);
        }

        $runescapeUserMakingRequest = RunescapeUser::where('discord_id', '=', $discordUserId)->first();

        if (!$runescapeUserMakingRequest) {
            return response(["message" => "Appears your discord user has not been setup"], 401);
        }

        if (!$runescapeUserMakingRequest->admin) {
            return response(["message" => "Only admins can do this action. Git Gud."], 401);
        }
        $clan = Clan::where('discord_server_Id', '=', $discordServerId)->first();
        if (!$clan) {
            return response(["message" => "The clan has not been setup."], 401);
        }

        $request->attributes->add(
            ['clan' => $clan]
        );

        $request->attributes->add(
            ['runescapeUserMakingRequest' => $runescapeUserMakingRequest]
        );
        return $next($request);
    }
}
