<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Services\UserService;
use Illuminate\Support\Facades\Route;


Route::get('/login', [AuthController::class, 'loginPage'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::view('/signup', 'signup')->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

Route::get('/user/{id}/profile', [AuthController::class, 'guestProfile'])->name('guest.profile');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    Route::get('/user/{email}/profile', [UserController::class, 'getUserProfile'])->name('user.profile');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
