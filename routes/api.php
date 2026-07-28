<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\TestimonialController;
use App\Http\Controllers\Api\V1\PageController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All API routes are prefixed with /api and use the api middleware group.
| Rate limiting is applied via the throttle:api middleware.
|
*/

// =============================================
// PUBLIC API (v1) — No authentication required
// =============================================
Route::prefix('v1')->group(function () {

    // Auth
    Route::post('/login', [AuthController::class, 'login']);

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/categories', [ProductController::class, 'categories']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);

    // News
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{slug}', [NewsController::class, 'show']);

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/gallery/photos/{slug}', [GalleryController::class, 'photos']);
    Route::get('/gallery/videos', [GalleryController::class, 'videos']);
    Route::get('/gallery/audios', [GalleryController::class, 'audios']);

    // Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);

    // Pages
    Route::get('/pages', [PageController::class, 'index']);
    Route::get('/pages/{slug}', [PageController::class, 'show']);

    // Orders (public submission) — stricter rate limit to prevent abuse
    Route::post('/orders', [OrderController::class, 'store'])->middleware('throttle:10,1');

    // Contact (public submission) — stricter rate limit to prevent abuse
    Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:10,1');
});

// =============================================
// AUTHENTICATED API (v1) — Sanctum token required
// =============================================
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // User profile
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
