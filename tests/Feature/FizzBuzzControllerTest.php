<?php

namespace Tests\Feature;

use App\Actions\UpsertFizzBuzzRequestStat;
use Tests\TestCase;

class FizzBuzzControllerTest extends TestCase
{
    public function test_fizzbuzz_returns_correct_sequence(): void
    {
        $this->mock(UpsertFizzBuzzRequestStat::class, function ($mock) {
            $mock->shouldReceive('handle')->once();
        });

        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => 3,
            'int2' => 5,
            'limit' => 15,
            'str1' => 'fizz',
            'str2' => 'buzz',
        ]));

        $response->assertStatus(200)
            ->assertJson([
                'result' => '1,2,fizz,4,buzz,fizz,7,8,fizz,buzz,11,fizz,13,14,fizzbuzz',
            ]);
    }

    public function test_fizzbuzz_returns_correct_sequence_with_custom_strings(): void
    {
        $this->mock(UpsertFizzBuzzRequestStat::class, function ($mock) {
            $mock->shouldReceive('handle')->once();
        });

        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => 3,
            'int2' => 5,
            'limit' => 15,
            'str1' => 'foo',
            'str2' => 'bar',
        ]));

        $response->assertStatus(200)
            ->assertJson([
                'result' => '1,2,foo,4,bar,foo,7,8,foo,bar,11,foo,13,14,foobar',
            ]);
    }

    public function test_fizzbuzz_validation_fails_with_invalid_parameters(): void
    {
        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => 3,
            'int2' => 5,
            'limit' => 15,
            'str1' => 'fizz',
        ]));

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'str2' => ['The str2 field is required.'],
                ],
            ]);

        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => 3,
            'int2' => 3,
            'limit' => 15,
            'str1' => 'fizz',
            'str2' => 'buzz',
        ]));

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'int1' => ['int1 and int2 must be different.'],
                ],
            ]);

        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => 10,
            'int2' => 5,
            'limit' => 8,
            'str1' => 'fizz',
            'str2' => 'buzz',
        ]));

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'int1' => ['int1 must be less than or equal to limit.'],
                ],
            ]);

        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => -1,
            'int2' => 5,
            'limit' => 15,
            'str1' => 'fizz',
            'str2' => 'buzz',
        ]));

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'int1' => ['The int1 field must be at least 1.'],
                ],
            ]);

        $response = $this->getJson('/api/fizzbuzz?'.http_build_query([
            'int1' => 3,
            'int2' => 5,
            'limit' => 15,
            'str1' => 'this_string_is_too_long',
            'str2' => 'buzz',
        ]));

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'str1' => ['The str1 field must not be greater than 15 characters.'],
                ],
            ]);
    }
}
