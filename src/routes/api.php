<?php

use App\Http\Controllers\Custom\FineConrtoller;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::prefix('api') -> group(function () {
        Route::prefix('fines') -> group(function () {
            Route::delete('/{id}', [FineConrtoller::class, 'destroy']) -> name('api.fines.delete');
        });       
    });
});
