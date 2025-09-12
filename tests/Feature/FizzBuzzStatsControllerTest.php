<?php

namespace Tests\Feature;

use App\Models\FizzBuzzRequestStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FizzBuzzStatsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_stats_returns_null_when_no_data_exists(): void
    {
        $response = $this->getJson('/api/fizzbuzz/stats');

        $response->assertStatus(200)
            ->assertJson([
                'result' => [
                    'parameters' => [],
                    'hits' => 0,
                ],
            ]);
    }

    public function test_get_stats_returns_single_record(): void
    {
        FizzBuzzRequestStat::create([
            'int1' => 3,
            'int2' => 5,
            'limit' => 100,
            'str1' => 'fizz',
            'str2' => 'buzz',
            'hits' => 25,
        ]);

        $response = $this->getJson('/api/fizzbuzz/stats');

        $response->assertStatus(200)
            ->assertJson([
                'result' => [
                    'parameters' => [
                        'int1' => 3,
                        'int2' => 5,
                        'limit' => 100,
                        'str1' => 'fizz',
                        'str2' => 'buzz',
                    ],
                    'hits' => 25,
                ],
            ]);
    }

    public function test_get_stats_returns_most_used_request(): void
    {
        FizzBuzzRequestStat::create([
            'int1' => 3,
            'int2' => 5,
            'limit' => 100,
            'str1' => 'fizz',
            'str2' => 'buzz',
            'hits' => 25,
        ]);

        FizzBuzzRequestStat::create([
            'int1' => 2,
            'int2' => 4,
            'limit' => 50,
            'str1' => 'foo',
            'str2' => 'bar',
            'hits' => 50,
        ]);

        FizzBuzzRequestStat::create([
            'int1' => 7,
            'int2' => 11,
            'limit' => 200,
            'str1' => 'abc',
            'str2' => 'def',
            'hits' => 10,
        ]);

        $response = $this->getJson('/api/fizzbuzz/stats');

        $response->assertStatus(200)
            ->assertJson([
                'result' => [
                    'parameters' => [
                        'int1' => 2,
                        'int2' => 4,
                        'limit' => 50,
                        'str1' => 'foo',
                        'str2' => 'bar',
                    ],
                    'hits' => 50,
                ],
            ]);
    }
}
