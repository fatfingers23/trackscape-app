<?php

use App\Http\Controllers\BotController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PlayerController;
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


Route::prefix('clan')->group(function () {
    Route::post('{confirmationCode}/update/members', [\App\Http\Controllers\ClanController::class, "updateMembers_post"]);
    Route::post('chatlog', [\App\Http\Controllers\ChatLoggerController::class, "chatLog_post"]);
    Route::middleware(['runescapeAuth'])->get('chatlog/{amount}', [\App\Http\Controllers\ChatLoggerController::class, "chatLog_get"]);

});

Route::prefix('bot')->middleware(['auth:sanctum'])->group(function (){
    Route::get('clan/{discordId}', [BotController::class, "getClan"]);
    Route::get('clans', [BotController::class, "getAllClans"]);
});


Route::prefix('donations')->middleware(['auth:sanctum', 'runescapeAuth'])->group(function () {
    Route::post('add/donation', [\App\Http\Controllers\DonationsController::class, "addDonation_post"]);
    Route::post('list', [\App\Http\Controllers\DonationsController::class, "listDonations_post"]);
    Route::post('add/type', [\App\Http\Controllers\DonationsController::class, "addDonationType_post"]);
    Route::post('list/topDonators', [\App\Http\Controllers\DonationsController::class, "listTopDonatorsByType_post"]);
    Route::delete('remove/type', [\App\Http\Controllers\DonationsController::class, "removeDonationType_delete"]);
});

Route::prefix('player')->middleware(['auth:sanctum', 'runescapeAuth'])->group(function () {
    Route::get('inactive/{days}', [PlayerController::class, "getInactive"]);
});

Route::prefix('chat')->group(function (){
    Route::middleware(['wsAuth'])->post('osrs', [ChatController::class, 'osrsChat']);
    Route::middleware(['auth:sanctum'])->post('discord', [ChatController::class, 'discordChat']);
});
