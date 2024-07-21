<?php

use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'auth.register');
Route::resource('/posts', PostController::class)->middleware('auth');
Route::get('/search', [PostController::class, 'search'])->name('posts.search')->middleware('auth');




//Register

Route::get('/register', [RegisterUserController::class, 'register'])->name('register');

Route::post('/register', [RegisterUserController::class, 'store'])->name('register.store');

Route::post('logout', [LoginUserController::class, 'logout'])->name('logout');


//Login
Route::get('/login', [LoginUserController::class, 'login'])->name('login');
Route::post('/login', [LoginUserController::class, 'store'])->name('login.store');





