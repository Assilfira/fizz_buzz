<?php

namespace App\Actions;

use App\Models\FizzBuzzRequestStat;
use Illuminate\Support\Facades\DB;

class UpsertFizzBuzzRequestStat
{
    /**
     * Execute the action to upsert and increment hits
     *
     * @param  array  $attributes  The FizzBuzz request parameters
     */
    public function handle(array $attributes): void
    {
        FizzBuzzRequestStat::upsert(
            [
                [
                    'int1' => $attributes['int1'],
                    'int2' => $attributes['int2'],
                    'limit' => $attributes['limit'],
                    'str1' => $attributes['str1'],
                    'str2' => $attributes['str2'],
                    'hits' => 1,
                ],
            ],
            ['int1', 'int2', 'limit', 'str1', 'str2'],
            ['hits' => DB::raw('hits + 1')]
        );
    }
}
