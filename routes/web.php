<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SystemSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard - accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // System Settings
        Route::get('/settings', [SystemSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SystemSettingController::class, 'updateSetting'])->name('settings.update');
        Route::patch('/settings/profile', [SystemSettingController::class, 'updateProfile'])->name('settings.profile.update');
        Route::put('/settings/password', [SystemSettingController::class, 'updatePassword'])->name('settings.password.update');

        // User Management
        // User Management
        Route::resource('users', AdminUserController::class);

        // Rebar Management
        Route::controller(\App\Http\Controllers\RebarDashboardController::class)->prefix('rebar')->name('rebar.')->group(function () {
            Route::get('/', 'index')->name('dashboard');
            // Other charts/ajax routes can go here
        });

        Route::prefix('rebar')->name('rebar.')->group(function () {
            Route::resource('sites', \App\Http\Controllers\ProjectSiteController::class);
            Route::resource('requirements', \App\Http\Controllers\RebarRequirementController::class);
            Route::resource('cutting-logs', \App\Http\Controllers\RebarCuttingLogController::class);
            Route::resource('offcuts', \App\Http\Controllers\OffcutController::class);
            Route::patch('offcuts/{offcut}/status', [\App\Http\Controllers\OffcutController::class, 'updateStatus'])->name('offcuts.update-status');
            Route::post('cutting-plan/generate/{site}', [\App\Http\Controllers\ProjectSiteController::class, 'generateCuttingPlan'])->name('cutting-plan.generate');
            Route::get('reports', [\App\Http\Controllers\RebarReportController::class, 'index'])->name('reports');
        });
    });

    // Approvals: accessible to admins and managers
    Route::middleware(['auth','role:admin|manager'])->prefix('admin/rebar')->name('admin.rebar.')->group(function () {
        Route::resource('approvals', \App\Http\Controllers\ApprovalController::class);
        Route::patch('approvals/{approval}/approve', [\App\Http\Controllers\ApprovalController::class, 'approve'])->name('approvals.approve');
        Route::patch('approvals/{approval}/reject', [\App\Http\Controllers\ApprovalController::class, 'reject'])->name('approvals.reject');
    });



    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
});
