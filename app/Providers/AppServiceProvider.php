<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // DNS warm-up ping (non-blocking)
        try {
            Http::timeout(1)->get('http://www.textguru.in'); // just a warm-up
        } catch (\Exception $e) {
            // silently fail, this is just DNS warm-up
        }
    }
}
