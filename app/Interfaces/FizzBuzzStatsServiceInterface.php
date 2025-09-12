<?php

namespace App\Interfaces;

interface FizzBuzzStatsServiceInterface
{
    /**
     * Get the most used FizzBuzz request parameters and their hit count
     *
     * @return array|null Returns array with 'parameters' and 'hits' keys, or null if no stats exist
     */
    public function getMostUsedRequest(): ?array;
}
