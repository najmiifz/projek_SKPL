<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
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
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('admin/projects', [ProjectController::class, 'adminIndex'])->name('admin.projects');
        Route::get('admin/logs', [DashboardController::class, 'logActivities'])->name('admin.logs');
    });

    // PM routes
    Route::middleware(\App\Http\Middleware\IsPm::class)->group(function () {
        Route::resource('projects', ProjectController::class)->only(['index','show','store','create']);
        Route::get('projects/{project}/gantt', [ProjectController::class, 'ganttChart'])->name('projects.gantt');
        Route::get('projects/{project}/kanban', [ProjectController::class, 'kanbanBoard'])->name('projects.kanban');
        Route::post('projects/{project}/validate/{task}', [TaskController::class, 'validateTask'])->name('tasks.validate');
        Route::get('reports', [ProjectController::class, 'reports'])->name('reports.index');
        Route::get('reports/download', [ProjectController::class, 'downloadReport'])->name('reports.download');
    });

    // Tasks: admin and pm can see tasks index; members see their own via TaskController logic
    Route::resource('tasks', TaskController::class)->only(['index','show','update','store']);
    Route::get('my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks');
    Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    
    // Task comments and uploads (authenticated users)
    Route::post('tasks/{task}/comment', [TaskController::class, 'storeComment'])->name('tasks.comment');
    Route::post('tasks/{task}/upload', [TaskController::class, 'uploadFile'])->name('tasks.upload');
    
    // Notifications
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('notifications/{notification}/read', [DashboardController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [DashboardController::class, 'markAllAsRead'])->name('notifications.read-all');
    
    // Member: View project detail (read only)
    Route::get('member/project/{project}', [ProjectController::class, 'memberShow'])->name('member.project.show');
    
});

