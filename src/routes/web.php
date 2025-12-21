<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\FinesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnalystController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::prefix('reports')->group(function () {
        Route::get('', [ReportController::class, 'generateReport'])->name('reports.generate');
        Route::get('download/{type}', [ReportController::class, 'downloadReport'])->name('reports.download');
    });
    
    Route::prefix('about')->group(function () {
        Route::get('credits', [AboutController::class, 'credits'])->name('about.credits');
        Route::get('creditHistory', [AboutController::class, 'creditHistory'])->name('about.creditHistory');
        Route::get('rates', [AboutController::class, 'rates'])->name('about.rates');
    });
    
    Route::prefix('credits')->name('credits.')->group(function () {
        Route::get('{creditId}', [CreditController::class, 'show'])->name('show');
        
        Route::prefix('{creditId}/payments')->name('payments.')->group(function () {
            Route::get('create', [PaymentController::class, 'create'])->name('create');
            Route::post('', [PaymentController::class, 'store'])->name('store');
        });

        Route::prefix('{creditId}/fines')->name('fines.')->group(function () {
            Route::patch('{fineId}', [FinesController::class, 'update'])->name('update');
        });
    });
    
    Route::middleware(['role:1'])->prefix('client')->name('client.')->group(function () {
        Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        Route::get('credits', [ClientController::class, 'credits'])->name('credits');
        Route::get('applications', [ClientController::class, 'applications'])->name('applications');
        Route::get('{userId}', [ClientController::class, 'show'])->name('show');
        
        Route::prefix('credits')->name('credits.')->group(function () {
            Route::post('', [CreditController::class, 'store'])->name('store');
            Route::get('create', [CreditController::class, 'create'])->name('create');
            Route::get('{clientId}/history', [CreditController::class, 'history'])->name('history');
        });
    });
    
    Route::middleware(['role:2'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
        Route::get('clients', [ManagerController::class, 'clients'])->name('clients');
        Route::get('applications', [ManagerController::class, 'applications'])->name('applications');
        Route::get('credits', [ManagerController::class, 'credits'])->name('credits');
        Route::get('analytics', [ManagerController::class, 'analytics'])->name('analytics');
        
        Route::prefix('clients/{clientId}')->group(function () {
            Route::get('', [ManagerController::class, 'showClient'])->name('clients.show');
            Route::put('', [ManagerController::class, 'updateClient'])->name('clients.update');
            Route::post('credits', [ManagerController::class, 'createCredit'])->name('clients.credits.create');
        });
        
        Route::prefix('applications/{applicationId}')->group(function () {
            Route::put('approve', [ManagerController::class, 'approveApplication'])->name('applications.approve');
            Route::put('reject', [ManagerController::class, 'rejectApplication'])->name('applications.reject');
        });
    });

    Route::middleware(['role:3'])->prefix('analyst')->name('analyst.')->group(function () {
        Route::get('dashboard', [AnalystController::class, 'dashboard'])->name('dashboard');
        Route::get('risk-assessment', [AnalystController::class, 'riskAssessment'])->name('risk-assessment');
        Route::get('overdue-credits', [AnalystController::class, 'overdueCredits'])->name('overdue-credits');
        Route::get('reports', [AnalystController::class, 'generateReport'])->name('reports');
    });
    
    Route::middleware(['role:4'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::get('credit-types', [AdminController::class, 'creditTypes'])->name('credit-types');
        Route::get('entity-types', [AdminController::class, 'entityTypes'])->name('entity-types');
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('reports', [AdminController::class, 'reports'])->name('reports');
        
        Route::prefix('users')->group(function () {
            Route::post('', [AdminController::class, 'createUser'])->name('users.create');
            Route::put('{userId}', [AdminController::class, 'updateUser'])->name('users.update');
            Route::delete('{userId}', [AdminController::class, 'deleteUser'])->name('users.delete');
        });
        
        Route::prefix('credit-types')->group(function () {
            Route::post('', [AdminController::class, 'createCreditType'])->name('credit-types.create');
            Route::put('{typeId}', [AdminController::class, 'updateCreditType'])->name('credit-types.update');
            Route::delete('{typeId}', [AdminController::class, 'deleteCreditType'])->name('credit-types.delete');
        });
        
        Route::prefix('entity-types')->group(function () {
            Route::post('', [AdminController::class, 'createEntityType'])->name('entity-types.create');
        });
    });
});

Route::middleware(['auth', 'role:4'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('cache-clear', function() {
        Artisan::call('cache:clear');
        return redirect()->route('admin.settings')->with('success', 'Кэш очищен');
    })->name('cache.clear');
    
    Route::get('route-cache', function() {
        Artisan::call('route:cache');
        return redirect()->route('admin.settings')->with('success', 'Маршруты закэшированы');
    })->name('route.cache');
    
    Route::get('view-cache', function() {
        Artisan::call('view:cache');
        return redirect()->route('admin.settings')->with('success', 'Представления закэшированы');
    })->name('view.cache');
    
    Route::get('config-cache', function() {
        Artisan::call('config:cache');
        return redirect()->route('admin.settings')->with('success', 'Конфигурация закэширована');
    })->name('config.cache');
});