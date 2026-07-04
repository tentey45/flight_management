<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostMetaController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::resource('users', UserController::class);
Route::resource('categories', PostCategoryController::class);
Route::resource('posts', PostController::class);
Route::resource('metas', PostMetaController::class)->except(['create', 'store', 'destroy', 'show']);

Route::post('posts/{post}/comments', [PostCommentController::class, 'store'])->name('comments.store');
Route::resource('comments', PostCommentController::class)->except(['create', 'store', 'show']);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');