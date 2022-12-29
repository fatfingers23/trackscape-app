<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ChatAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $osrsId = $request->header('osrs_id');

        if($osrsId == null){
            abort(401);
        }

        $user = User::where('osrs_id', '=', $osrsId)->first();
        if($user == null){
            $user = User::create([
                'name' => $osrsId,
                'email' => $osrsId,
                'password' => 'JumbleMess',
                'osrs_id' => $osrsId
            ]);
        }
        \Auth::login($user);
        return $next($request);
    }
}
