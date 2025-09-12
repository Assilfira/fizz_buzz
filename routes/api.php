<?php

use App\Http\Controllers\FizzBuzzController;
use App\Http\Controllers\FizzBuzzStatsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'fizzbuzz'], function () {
    Route::get('/', [FizzBuzzController::class, 'index']);
    Route::get('/stats', [FizzBuzzStatsController::class, 'index']);
});
