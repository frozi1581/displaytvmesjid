<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\PlayerControllerDev;

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

// API Routes for Monthly Prayer Data System
Route::prefix('player/{token}')->group(function () {

    // Check data status - untuk cek apakah ada update data baru
    Route::get('/check-status', [PlayerControllerDev::class, 'checkDataStatus'])
        ->name('api.player.check-status');

    // Get current prayer times data - untuk mendapatkan data prayer times terbaru
    Route::get('/prayer-times', [PlayerControllerDev::class, 'getPrayerTimes'])
        ->name('api.player.prayer-times');

    // Invalidate cache - untuk admin/debugging (optional)
    Route::post('/invalidate-cache', [PlayerControllerDev::class, 'invalidateCache'])
        ->name('api.player.invalidate-cache');

});

// Alternative: Jika ingin menggunakan prefix yang berbeda
Route::prefix('masjid-api')->group(function () {

    Route::get('/{token}/status', [PlayerControllerDev::class, 'checkDataStatus']);
    Route::get('/{token}/prayers', [PlayerControllerDev::class, 'getPrayerTimes']);
    Route::post('/{token}/refresh', [PlayerControllerDev::class, 'invalidateCache']);

});
