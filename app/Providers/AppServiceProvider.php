<?php

namespace App\Providers;

use App\Hashing\LegacyCompatibleHasher;
use Illuminate\Hashing\HashManager;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->resolving('hash', function (HashManager $hash): void {
            $hash->extend('legacy', fn () => new LegacyCompatibleHasher);
        });
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
