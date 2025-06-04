<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CreditController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AnalyticController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Маршруты для клиентов
Route::middleware(['auth', 'role:client'])->group(function () {
    // Кредиты
    Route::prefix('credits')->group(function () {
        Route::get('/', [CreditController::class, 'index'])->name('credits.index');
        Route::get('/create', [CreditController::class, 'create'])->name('credits.create');
        Route::post('/', [CreditController::class, 'store'])->name('credits.store');
        Route::get('/{credit}', [CreditController::class, 'show'])->name('credits.show');
    });
    
    // Платежи
    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/{credit}', [PaymentController::class, 'store'])->name('payments.store');
    });
});

// Маршруты для аналитиков
Route::middleware(['auth', 'role:analyst'])->prefix('analytics')->group(function () {
    Route::get('/risks', [AnalyticController::class, 'risks'])->name('analytics.risks');
    Route::get('/reports', [AnalyticController::class, 'reports'])->name('analytics.reports');
});

// Маршруты для менеджеров
Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function () {
    Route::get('/applications', [ManagerController::class, 'applications'])->name('manager.applications');
    Route::get('/clients', [ManagerController::class, 'clients'])->name('manager.clients');
    
    // Управление заявками
    Route::prefix('applications')->group(function () {
        Route::get('/{application}', [ManagerController::class, 'showApplication'])->name('manager.applications.show');
        Route::put('/{application}/approve', [ManagerController::class, 'approve'])->name('manager.applications.approve');
        Route::put('/{application}/reject', [ManagerController::class, 'reject'])->name('manager.applications.reject');
    });
});

// Маршруты для администраторов
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
    
    // Управление пользователями
    Route::prefix('users')->group(function () {
        Route::post('/', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::put('/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });
});

require __DIR__.'/auth.php';
