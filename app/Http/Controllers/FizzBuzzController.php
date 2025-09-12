<?php

namespace App\Http\Controllers;

use App\Http\Requests\FizzBuzzRequest;
use App\Services\SequenceServiceInterface;
use Illuminate\Http\JsonResponse;

class FizzBuzzController extends Controller
{
    public function __construct(
        private readonly SequenceServiceInterface $sequenceService
    ) {}

    public function index(FizzBuzzRequest $request): JsonResponse
    {
        $int1 = (int)$request->input('int1');
        $int2 = (int)$request->input('int2');
        $limit = (int)$request->input('limit');
        $str1 = (string)$request->input('str1');
        $str2 = (string)$request->input('str2');

        $data = $this->sequenceService->generate($int1, $int2, $limit, $str1, $str2);

        return response()->json([
            'result' => $data
        ]);
    }
}
