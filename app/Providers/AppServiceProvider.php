<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Jangan lupa tambahin baris ini di atas

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
        // Memaksa protokol HTTPS agar aman di production (Railway)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}