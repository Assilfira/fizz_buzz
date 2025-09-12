<?php

namespace App\Services;

use App\Interfaces\FizzBuzzStatsServiceInterface;
use App\Models\FizzBuzzRequestStat;

class FizzBuzzStatsService implements FizzBuzzStatsServiceInterface
{
    /**
     * Get the most used FizzBuzz request parameters and their hit count
     *
     * @return array|null Returns array with 'parameters' and 'hits' keys, or null if no stats exist
     */
    public function getMostUsedRequest(): ?array
    {
        $mostUsedRequest = FizzBuzzRequestStat::orderBy('hits', 'desc')
            ->first();

        if (! $mostUsedRequest) {
            return null;
        }

        return [
            'parameters' => [
                'int1' => $mostUsedRequest->int1,
                'int2' => $mostUsedRequest->int2,
                'limit' => $mostUsedRequest->limit,
                'str1' => $mostUsedRequest->str1,
                'str2' => $mostUsedRequest->str2,
            ],
            'hits' => $mostUsedRequest->hits,
        ];
    }
}
