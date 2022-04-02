<?php


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

use App\Http\Controllers\ClanController;
use App\Http\Controllers\PbController;
use Illuminate\Support\Facades\Route;

//
//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::prefix('clan')->middleware('auth:sanctum')->group(function () {
    Route::post('signup', [ClanController::class, "signUpClan_post"]);
});


Route::get('/invite/{rsn}', [\App\Http\Controllers\Invite::class, 'invite']);
Route::get('/invite', function () {
    return redirect("https://discord.gg/PWy8pm782p");

});

Route::get('/collectionlog/{clanId}', [\App\Http\Controllers\CollectionLogsController::class, 'index'])->name('collection-logs');
Route::get('/pb/{clanId}', [PbController::class, 'index'])->name('pb');


Route::name('clan')->prefix('clan')->group(function () {
    Route::get('/{clanName}', [ClanController::class, "landingPage"])->name('landing-page');
});