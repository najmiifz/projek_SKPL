<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes (for all authenticated users)
    Route::get('profile', [UserController::class, 'profile'])->name('profile.edit');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');
    
    // Admin routes
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::get('settings', [UserController::class, 'settings'])->name('settings');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // PM routes
    Route::middleware(\App\Http\Middleware\IsPm::class)->group(function () {
        Route::resource('projects', ProjectController::class)->only(['index','show','store','create']);
    });

    // Tasks: admin and pm can see tasks index; members see their own via TaskController logic
    Route::resource('tasks', TaskController::class)->only(['index','show','update','store']);

    // Task comments and uploads (authenticated users)
    Route::post('tasks/{task}/comment', [TaskController::class, 'storeComment'])->name('tasks.comment');
    Route::post('tasks/{task}/upload', [TaskController::class, 'uploadFile'])->name('tasks.upload');
    
});

