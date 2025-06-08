<?php

use App\Http\Controllers\Custom\CreditConrtoller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dash/manager', function() {
    return view('pages.manager');
});

Route::get('/dash/analytics', function() {
    return view('pages.analytics');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('credits')->group(function () {
        Route::get('/{id}', [CreditConrtoller::class, 'show']) -> name('credits.show');
    });
});


require __DIR__.'/auth.php';
require __DIR__.'/api.php';
