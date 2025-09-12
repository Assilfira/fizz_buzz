<?php

namespace App\Providers;

use App\Interfaces\FizzBuzzStatsServiceInterface;
use App\Interfaces\SequenceServiceInterface;
use App\Services\FizzBuzzStatsService;
use App\Services\SequenceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SequenceServiceInterface::class, SequenceService::class);
        $this->app->bind(FizzBuzzStatsServiceInterface::class, FizzBuzzStatsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
