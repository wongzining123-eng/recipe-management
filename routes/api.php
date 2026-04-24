<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Admin API routes
Route::middleware(['auth', 'can:isAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard',        [AdminController::class, 'index']);
    Route::get('/recipes',          [AdminController::class, 'recipes']);
    Route::delete('/recipes/{recipe}', [AdminController::class, 'deleteRecipe']);
    Route::get('/users',            [AdminController::class, 'users']);
    Route::patch('/users/{user}/toggle-role', [AdminController::class, 'toggleRole']);
});

// Profile API routes (React-based for admin)
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [App\Http\Controllers\ProfileController::class, 'getProfile']);
    Route::put('/', [App\Http\Controllers\ProfileController::class, 'updateProfile']);
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword']);
    Route::delete('/', [App\Http\Controllers\ProfileController::class, 'destroyAccount']);
});