<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PromoCodeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes pour les codes promo
Route::prefix('promo-codes')->group(function () {
    Route::post('/validate', [PromoCodeController::class, 'validate']);
    Route::post('/apply', [PromoCodeController::class, 'apply']);
    Route::delete('/remove', [PromoCodeController::class, 'remove']);
    Route::get('/applied', [PromoCodeController::class, 'getApplied']);
    Route::post('/calculate-total', [PromoCodeController::class, 'calculateTotal']);
});
