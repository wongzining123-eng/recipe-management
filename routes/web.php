<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
// This can wait or modified until the neccessary controllers are created.
Route::get('/recipes/create', [RecipeController::class, 'create']);
Route::get('/recipes/edit', [RecipeController::class, 'edit']);
Route::get('/recipes/delete', [RecipeController::class, 'delete']);

Route::get('/categories/index', [CategoryController::class, 'index']);
Route::get('/categories/{category}/recipes', [CategoryController::class, 'show']);
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('recipes', App\Http\Controllers\RecipeController::class);
