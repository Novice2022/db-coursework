<?php

namespace App\Providers;

use App\Models\CreditsModel;
use Exception;
use Illuminate\Database\Eloquent\Model;
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
    
        if (config('database.default') === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
        }
        
        Model::unguard();
        
        CreditsModel::retrieved(function ($model) {
            if (!$model->hasCast('start_date')) {
                try {
                    $model->start_date = $model->start_date 
                        ? \Carbon\Carbon::parse($model->start_date) 
                        : null;
                } catch (Exception $e) {
                    // Оставляем как есть
                }
            }
            
            if (!$model->hasCast('end_date')) {
                try {
                    $model->end_date = $model->end_date 
                        ? \Carbon\Carbon::parse($model->end_date) 
                        : null;
                } catch (Exception $e) {
                    // Оставляем как есть
                }
            }
        });
    }
}
