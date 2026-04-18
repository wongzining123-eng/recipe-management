<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Home route (can be used for dashboard or redirect to recipes)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Recipe resource routes
Route::resource('recipes', App\Http\Controllers\RecipeController::class);

// Route for user's own recipes
Route::get('/my-recipes', [App\Http\Controllers\RecipeController::class, 'myRecipes'])->name('my.recipes');

// Category routes for regular users (Blade)
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

// Admin API routes
Route::middleware(['auth', 'can:isAdmin'])->prefix('admin/api')->group(function () {
    Route::get('/dashboard',        [AdminController::class, 'index']);
    Route::get('/recipes',          [AdminController::class, 'recipes']);
    Route::delete('/recipes/{recipe}', [AdminController::class, 'deleteRecipe']);
    Route::get('/users',            [AdminController::class, 'users']);
    Route::patch('/users/{user}/toggle-role', [AdminController::class, 'toggleRole']);
});

// Admin views (React app)
Route::middleware(['auth', 'can:isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('layouts.admin-react');
    })->name('dashboard');

    Route::get('/users', function () {
        return view('layouts.admin-react');
    })->name('users');

    Route::get('/profile', function () {
        return view('layouts.admin-react');
    })->name('profile');
});

// Profile API routes (React-based for admin)
Route::middleware(['auth'])->prefix('api/profile')->group(function () {
    Route::get('/', [App\Http\Controllers\ProfileController::class, 'getProfile']);
    Route::put('/', [App\Http\Controllers\ProfileController::class, 'updateProfile']);
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword']);
    Route::delete('/', [App\Http\Controllers\ProfileController::class, 'destroyAccount']);
});

// Profile routes for regular users (Blade)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});