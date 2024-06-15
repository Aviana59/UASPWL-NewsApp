<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsContoller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('post.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('post.logout');


// Post news routes
Route::get('/admin/posts', function () {
    return view('admin.posts');
})->middleware('auth');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('posts', PostsContoller::class);
});

// User routes
Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/user', [UserController::class, 'user']);
});
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
});
