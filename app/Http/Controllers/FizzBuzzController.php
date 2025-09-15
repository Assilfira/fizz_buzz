<?php

namespace App\Http\Controllers;

use App\Actions\UpsertFizzBuzzRequestStat;
use App\Http\Requests\FizzBuzzRequest;
use App\Interfaces\SequenceServiceInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'FizzBuzz API',
    description: 'API for generating FizzBuzz sequences with customizable parameters'
)]
#[OA\Server(
    url: '/api',
    description: 'API Server'
)]
class FizzBuzzController extends Controller
{
    public function __construct(
        private readonly SequenceServiceInterface $sequenceService
    ) {}

    #[OA\Get(
        path: '/fizzbuzz',
        summary: 'Generate FizzBuzz sequence',
        description: 'Generates a FizzBuzz sequence based on the provided parameters and tracks usage statistics',
        tags: ['FizzBuzz']
    )]
    #[OA\Parameter(
        name: 'int1',
        description: 'First integer for FizzBuzz logic (must be different from int2)',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 5000),
        example: 3
    )]
    #[OA\Parameter(
        name: 'int2',
        description: 'Second integer for FizzBuzz logic (must be different from int1)',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 5000),
        example: 5
    )]
    #[OA\Parameter(
        name: 'limit',
        description: 'Upper limit for the sequence generation',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 5000),
        example: 100
    )]
    #[OA\Parameter(
        name: 'str1',
        description: 'String to replace multiples of int1',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'string', maxLength: 15),
        example: 'fizz'
    )]
    #[OA\Parameter(
        name: 'str2',
        description: 'String to replace multiples of int2',
        in: 'query',
        required: true,
        schema: new OA\Schema(type: 'string', maxLength: 15),
        example: 'buzz'
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response with FizzBuzz sequence',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'result',
                    type: 'array',
                    items: new OA\Items(type: 'string'),
                    example: ['1', '2', 'fizz', '4', 'buzz', 'fizz', '7', '8', 'fizz', 'buzz', '11', 'fizz', '13', '14', 'fizzbuzz']
                )
            ]
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Validation error',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'The given data was invalid.'),
                new OA\Property(
                    property: 'errors',
                    type: 'object',
                    additionalProperties: new OA\AdditionalProperties(
                        type: 'array',
                        items: new OA\Items(type: 'string')
                    )
                )
            ]
        )
    )]
    public function index(FizzBuzzRequest $request, UpsertFizzBuzzRequestStat $upsertFizzBuzzRequestStat): JsonResponse
    {
        $int1 = (int) $request->input('int1');
        $int2 = (int) $request->input('int2');
        $limit = (int) $request->input('limit');
        $str1 = (string) $request->input('str1');
        $str2 = (string) $request->input('str2');

        $data = $this->sequenceService->generate($int1, $int2, $limit, $str1, $str2);
        $upsertFizzBuzzRequestStat->handle([
            'int1' => $int1,
            'int2' => $int2,
            'limit' => $limit,
            'str1' => $str1,
            'str2' => $str2,
        ]);

        return response()->json([
            'result' => $data,
        ]);
    }
}
