<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth') -> group(function () {
    Route::prefix('profile') -> group(function () {
        Route::get('', [ProfileController::class, 'edit'])
            -> name('profile.edit');
        Route::patch('', [ProfileController::class, 'update'])
            -> name('profile.update');
        Route::delete('', [ProfileController::class, 'destroy'])
            -> name('profile.destroy');
    });

    Route::prefix('client') -> group(function () {
        Route::get('{userId}', [ClientController::class, 'index'])
            -> name('client');
        Route::get('{clientId}/creditHistory', [CreditController::class, 'history'])
            -> name('credit.history');
    });
        
    Route::prefix('credit') -> group(function () {
        Route::get('{id}', [CreditController::class, 'show'])
            -> name('credit.index');
        Route::post('', [CreditController::class, 'store'])
            -> name('credit.store');
    });

    Route::prefix('about') -> group(function () {
        Route::get('credits', [AboutController::class, 'credits'])
            -> name('about.credits');
        Route::get('creditHistory', [AboutController::class, 'creditHistory'])
            -> name('about.creditHistory');
        Route::get('rates', [AboutController::class, 'rates'])
            -> name('about.rates');
    });

    Route::get('manager/{id}', function (int $id) {
        
    }) -> name('manager');

    Route::get('analyst/{id}', function (int $id) {
        
    }) -> name('analyst');

    Route::get('admin/{id}', function (int $id) {
        
    }) -> name('admin');


});


require __DIR__.'/auth.php';
