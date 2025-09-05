<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\FinesController;
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
        
    Route::prefix('credit') -> group(function () {
        Route::get('{id}', [CreditController::class, 'index'])
            -> name('credit.index');
        Route::post('', [CreditController::class, 'store'])
            -> name('credit.store');
    });

    // Route::prefix('payment') -> group(function () {
    //     Route::post('', [, 'store']);
    //     Route::patch('{id}', [, 'update']);
    // });

    Route::prefix('fines') -> group(function () {
        Route::post('', [FinesController::class, 'store'])
            -> name('fine.create');
        Route::patch('{id}', [FinesController::class, 'update'])
            -> name('fine.update');
    });

    Route::prefix('about') -> group(function () {
        Route::get('credits', [AboutController::class, 'credits'])
            -> name('about.credits');
        Route::get('creditHistory', [AboutController::class, 'creditHistory'])
            -> name('about.creditHistory');
        Route::get('rates', [AboutController::class, 'rates'])
            -> name('about.rates');
    });

    Route::prefix('client') -> group(function () {
        Route::get('{userId}', [ClientController::class, 'index'])
            -> name('client');
        Route::get('{clientId}/creditHistory', [CreditController::class, 'history'])
            -> name('credit.history');
    });

    Route::get('manager/{id}', function (int $id) {
        
    }) -> name('manager');

    Route::get('analyst/{id}', function (int $id) {
        
    }) -> name('analyst');

    Route::get('admin/{id}', function (int $id) {
        
    }) -> name('admin');


});


require __DIR__.'/auth.php';
