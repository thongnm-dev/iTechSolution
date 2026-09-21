<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);
Route::get('/posts/{slug}/related', [PostController::class, 'related']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact');
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
