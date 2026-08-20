<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HealthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class);

Route::get('/districts', [App\Http\Controllers\Api\DistrictController::class, 'index']);
Route::get('/tags', [App\Http\Controllers\Api\TagController::class, 'index']);
Route::get('/hotels', [App\Http\Controllers\Api\HotelController::class, 'index']);
Route::get('/hotels/{slug}', [App\Http\Controllers\Api\HotelController::class, 'show']);

Route::get('/news', [App\Http\Controllers\Api\ArticleController::class, 'index']);
Route::get('/news/{slug}', [App\Http\Controllers\Api\ArticleController::class, 'show']);
Route::get('/gallery', [App\Http\Controllers\Api\GalleryController::class, 'index']);
Route::get('/settings', [App\Http\Controllers\Api\SettingController::class, 'index']);
Route::get('/settings/{key}', [App\Http\Controllers\Api\SettingController::class, 'show']);
Route::post('/contact', [App\Http\Controllers\Api\ContactController::class, 'store']);

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
