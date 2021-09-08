<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->name('dashboard');
//
//
//Route::prefix('clan')->middleware('auth:sanctum')->group(function () {
//    Route::post('signup', [\App\Http\Controllers\ClanController::class, "signUpClan_post"]);
//});

Route::get('confirmation/{clanConfirmationCode}/{compId}', [\App\Http\Controllers\CompetitionController::class, 'confirmationCode_get']);

