<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\AnalystController;
use App\Http\Controllers\ManagerController;

// Общие роуты (доступные всем)
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Аутентификация
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Роуты для авторизованных пользователей с ролью 'client'
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Профиль пользователя
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('profile.show');
        Route::get('/edit', [UserController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [UserController::class, 'update'])->name('profile.update');
    });
    
    // Кредиты пользователя
    Route::prefix('credits')->group(function () {
        Route::get('/', [CreditController::class, 'index'])->name('credits.index');
        Route::get('/{credit}', [CreditController::class, 'show'])->name('credits.show');
    });
});

// Роуты для аналитика
Route::middleware(['auth', 'role:analyst'])->prefix('analyst')->group(function () {
    Route::get('/', [AnalystController::class, 'index'])->name('analyst.home');
    // Дополнительные роуты аналитика можно добавить здесь
});

// Роуты для менеджера
Route::middleware(['auth', 'role:manager'])->prefix('manager')->group(function () {
    Route::get('/', [ManagerController::class, 'index'])->name('manager.home');
    // Дополнительные роуты менеджера можно добавить здесь
});

// При необходимости можно добавить fallback-роут
Route::fallback(function () {
    return redirect()->route('welcome');
});
