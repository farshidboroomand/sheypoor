<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Player\Controllers\PlayerController;

Route::group([
    'prefix' => 'players',
    'namespace' => 'Player\Controllers',
], static function () {
    Route::post('/', [PlayerController::class, 'store'])->name('player.store');
    Route::get('/top/{limit?}', [PlayerController::class, 'getTopPlayer'])->name('player.top');
    Route::patch('/{player}/update_score', [PlayerController::class, 'updatePlayerScore'])->name('player.update.score');
    Route::get('/{player}/rank', [PlayerController::class, 'getPlayerRank'])->name('player.rank');
});
