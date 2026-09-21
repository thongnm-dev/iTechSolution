<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        // The Vue frontend's API resources match Post/Category/Tag/Author
        // shapes directly, without a "data" envelope.
        JsonResource::withoutWrapping();

        // The contact form is public (no auth), so it needs a tighter limit
        // than the default "api" throttle to stay usable against spam.
        RateLimiter::for('contact', function ($request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
