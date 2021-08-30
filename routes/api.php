<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('clan')->middleware('auth:sanctum')->group(function () {
    Route::post('signup', [\App\Http\Controllers\ClanController::class, "signUpClan_post"]);
    Route::get('wom/sync/{discordServerId}', [\App\Http\Controllers\ClanController::class, "updateMembersWom_get"]);
});

Route::post('clan/{confirmationCode}/update/members', [\App\Http\Controllers\ClanController::class, "updateMembers_post"]);

