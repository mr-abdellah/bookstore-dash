<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PublishingHouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Public routes
Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index']);
    Route::get('/all', [AuthorController::class, 'getAllAuthors']);
    Route::get('/{id}', [AuthorController::class, 'getAuthorById']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/all', [CategoryController::class, 'getAllCategories']);
    Route::get('/{slug}', [CategoryController::class, 'show']);
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'all']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::get('/{id}/related', [BookController::class, 'relatedBooks']);
    Route::get('/category/{categorySlug}', [BookController::class, 'booksByCategory']);
    Route::get('/author/{authorId}', [BookController::class, 'booksByAuthor']);

    // Nested resources
    Route::get('/{bookId}/reviews', [ReviewController::class, 'all']);
    Route::get('/{bookId}/favorites', [FavoriteController::class, 'all']);
});

Route::prefix('publishing-houses')->group(function () {
    Route::get('/all', [PublishingHouseController::class, 'getAll']);
    Route::get('/', [PublishingHouseController::class, 'index']);
    Route::get('/{id}', [PublishingHouseController::class, 'show']);
});


// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Book reviews
    Route::prefix('books')->group(function () {
        Route::post('/{bookId}/reviews', [ReviewController::class, 'store']);
        Route::post('/{bookId}/favorites', [FavoriteController::class, 'store']);
    });

    // Reviews management
    Route::prefix('reviews')->group(function () {
        Route::put('/{id}', [ReviewController::class, 'update']);
        Route::delete('/{id}', [ReviewController::class, 'delete']);
    });

    // Favorites management
    Route::prefix('favorites')->group(function () {
        Route::put('/{id}', [FavoriteController::class, 'update']);
        Route::delete('/{id}', [FavoriteController::class, 'delete']);
    });

    // orders
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::get('/{id}', [OrderController::class, 'show']);
        Route::post('/', [OrderController::class, 'store']);
    });
});

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});
