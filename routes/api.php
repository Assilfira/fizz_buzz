<?php

use App\Http\Controllers\FizzBuzzController;
use Illuminate\Support\Facades\Route;

Route::get('/fizzbuzz', [FizzBuzzController::class, 'index']);
