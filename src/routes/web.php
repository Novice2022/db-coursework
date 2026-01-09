<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AnalystController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

// Общие маршруты для авторизованных пользователей
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        switch ($user->role_id) {
            case 1:
                return redirect()->route('client.dashboard');
            case 2:
                return redirect()->route('manager.dashboard');
            case 3:
                return redirect()->route('analyst.dashboard');
            case 4:
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('home');
        }
    })->name('dashboard');
    
    // Маршруты профиля (используют стандартный ProfileController)
    Route::prefix('profile')->group(function () {
        Route::get('', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
    // API токены (только для авторизованных пользователей)
    Route::post('/api/token/create', function (Request $request) {
        $token = $request->user()->createToken('api-token');
        
        $route = match($request->user()->role_id) {
            1 => 'client.profile',
            2 => 'manager.dashboard',
            3 => 'analyst.dashboard',
            4 => 'admin.dashboard',
            default => 'home',
        };
        
        return redirect()->route($route)
            ->with('token', $token->plainTextToken)
            ->with('success', 'API токен создан');
    })->name('api.token.create');
    
    Route::delete('/api/token/revoke', function (Request $request) {
        $request->user()->tokens()->delete();
        
        $route = match($request->user()->role_id) {
            1 => 'client.profile',
            2 => 'manager.dashboard',
            3 => 'analyst.dashboard',
            4 => 'admin.dashboard',
            default => 'home',
        };
        
        return redirect()->route($route)
            ->with('success', 'Все API токены отозваны');
    })->name('api.token.revoke');
});

// Маршруты для клиентов
Route::middleware(['auth', 'role:1'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/credits', [ClientController::class, 'credits'])->name('credits.index');
    Route::get('/credits/{id}', [ClientController::class, 'creditDetails'])->name('credits.show');
    Route::get('/payments', [ClientController::class, 'payments'])->name('payments.index');
    Route::get('/profile', [ClientController::class, 'profile'])->name('profile');
    Route::patch('/profile/update', [ClientController::class, 'updateProfile'])->name('profile.update');
});

// Маршруты для менеджеров
Route::middleware(['auth', 'role:2'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/clients', [ManagerController::class, 'clients'])->name('clients.index');
    Route::get('/clients/{id}', [ManagerController::class, 'clientDetails'])->name('clients.show');
    Route::get('/credits', [ManagerController::class, 'credits'])->name('credits.index');
    Route::get('/credits/create', [ManagerController::class, 'createCredit'])->name('credits.create');
    Route::post('/credits', [ManagerController::class, 'storeCredit'])->name('credits.store');
    Route::get('/credits/{id}', [ManagerController::class, 'creditDetails'])->name('credits.show');
    Route::get('/reports', [ManagerController::class, 'reports'])->name('reports.index');
    Route::get('/reports/clients', [ManagerController::class, 'clientsReport'])->name('reports.clients');
    Route::get('/reports/financial', [ManagerController::class, 'financialReport'])->name('reports.financial');
});

// Маршруты для аналитиков
Route::middleware(['auth', 'role:3'])->prefix('analyst')->name('analyst.')->group(function () {
    Route::get('/dashboard', [AnalystController::class, 'dashboard'])->name('dashboard');
    Route::get('/risk', [AnalystController::class, 'riskAnalysis'])->name('risk.index');
    Route::get('/reports', [AnalystController::class, 'reports'])->name('reports.index');
    Route::get('/reports/risk', [AnalystController::class, 'riskReport'])->name('reports.risk');
    Route::get('/export', [AnalystController::class, 'export'])->name('export');
    Route::get('/export/credits', [AnalystController::class, 'exportCredits'])->name('export.credits');
    Route::get('/export/payments', [AnalystController::class, 'exportPayments'])->name('export.payments');
});

// Маршруты для администраторов
Route::middleware(['auth', 'role:4'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::get('/audit', [AdminController::class, 'audit'])->name('audit.index');
});