<?php

namespace App\Services;

interface SequenceServiceInterface
{
    /**
     * Generate a sequence based on the provided parameters.
     *
     * @param int $int1 First integer for FizzBuzz logic
     * @param int $int2 Second integer for FizzBuzz logic
     * @param int $limit Upper limit for the sequence
     * @param string $str1 String to display for multiples of int1
     * @param string $str2 String to display for multiples of int2
     * @return string Generated sequence
     */
    public function generate(int $int1, int $int2, int $limit, string $str1, string $str2): string;
}
