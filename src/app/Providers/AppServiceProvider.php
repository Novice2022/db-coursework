<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        Schema::defaultStringLength(191);
    
        // For PostgreSQL UUID support
        if (config('database.default') === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        }
    }
}
