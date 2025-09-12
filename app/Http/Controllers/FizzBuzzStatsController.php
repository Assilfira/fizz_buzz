<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class FizzBuzzStatsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json();
    }
}
