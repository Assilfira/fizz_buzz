<?php

namespace Tests\Unit;

use App\Services\SequenceService;
use PHPUnit\Framework\TestCase;

class SequenceServiceTest extends TestCase
{
    private SequenceService $sequenceService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sequenceService = new SequenceService;
    }

    public function test_generates_basic_fizzbuzz_sequence(): void
    {
        $result = $this->sequenceService->generate(3, 5, 15, 'fizz', 'buzz');

        $expected = '1,2,fizz,4,buzz,fizz,7,8,fizz,buzz,11,fizz,13,14,fizzbuzz';
        $this->assertEquals($expected, $result);
    }

    public function test_generates_sequence_with_custom_strings(): void
    {
        $result = $this->sequenceService->generate(2, 3, 6, 'foo', 'bar');

        $expected = '1,foo,bar,foo,5,foobar';
        $this->assertEquals($expected, $result);
    }

    public function test_generates_sequence_with_limit_1(): void
    {
        $result = $this->sequenceService->generate(3, 5, 1, 'fizz', 'buzz');

        $this->assertEquals('1', $result);
    }

    public function test_generates_sequence_when_no_multiples(): void
    {
        $result = $this->sequenceService->generate(10, 15, 5, 'fizz', 'buzz');

        $expected = '1,2,3,4,5';
        $this->assertEquals($expected, $result);
    }
}
