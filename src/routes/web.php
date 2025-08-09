<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('detail') -> group(function () {
        Route::get('credit/{id}', [CreditController::class, 'show']) -> name('credit');
    });

    Route::get('client/{id}', [ClientController::class, 'index']) -> name('client');

    Route::get('manager/{id}', function (int $id) {
        
    }) -> name('manager');

    Route::get('analyst/{id}', function (int $id) {
        
    }) -> name('analyst');

    Route::get('admin/{id}', function (int $id) {
        
    }) -> name('admin');
});


require __DIR__.'/auth.php';
