<?php

namespace App\Http\Controllers;

use App\Interfaces\FizzBuzzStatsServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class FizzBuzzStatsController extends Controller
{
    public function __construct(
        private readonly FizzBuzzStatsServiceInterface $statsService
    ) {}

    #[OA\Get(
        path: '/fizzbuzz/stats',
        summary: 'Get FizzBuzz statistics',
        description: 'Retrieves the most frequently used FizzBuzz request parameters',
        tags: ['Statistics']
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response with statistics',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'result',
                    type: 'object',
                    nullable: true,
                    properties: [
                        new OA\Property(property: 'int1', type: 'integer', example: 3),
                        new OA\Property(property: 'int2', type: 'integer', example: 5),
                        new OA\Property(property: 'limit', type: 'integer', example: 100),
                        new OA\Property(property: 'str1', type: 'string', example: 'fizz'),
                        new OA\Property(property: 'str2', type: 'string', example: 'buzz'),
                        new OA\Property(property: 'hits', type: 'integer', example: 42)
                    ]
                )
            ]
        )
    )]
    public function index(): JsonResponse
    {
        $mostUsedRequest = $this->statsService->getMostUsedRequest();

        return response()->json([
            'result' => $mostUsedRequest,
        ]);
    }
}
