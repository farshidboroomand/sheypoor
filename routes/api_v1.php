<?php

use Illuminate\Support\Facades\Route;
use Modules\V1\Player\Controllers\PlayerController;

Route::group([
    'prefix' => 'players',
    'namespace' => 'Player\Controllers',
], static function () {
    Route::post('/', [PlayerController::class, 'store'])->name('player.store');
});
