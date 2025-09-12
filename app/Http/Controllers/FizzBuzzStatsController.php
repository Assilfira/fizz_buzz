<?php

namespace App\Http\Controllers;

use App\Interfaces\FizzBuzzStatsServiceInterface;
use Illuminate\Http\JsonResponse;

class FizzBuzzStatsController extends Controller
{
    public function __construct(
        private readonly FizzBuzzStatsServiceInterface $statsService
    ) {}

    public function index(): JsonResponse
    {
        $mostUsedRequest = $this->statsService->getMostUsedRequest();

        return response()->json([
            'result' => $mostUsedRequest,
        ]);
    }
}
