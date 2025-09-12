<?php

namespace App\Http\Controllers;

use App\Actions\UpsertFizzBuzzRequestStat;
use App\Http\Requests\FizzBuzzRequest;
use App\Interfaces\SequenceServiceInterface;
use Illuminate\Http\JsonResponse;

class FizzBuzzController extends Controller
{
    public function __construct(
        private readonly SequenceServiceInterface $sequenceService
    ) {}

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
