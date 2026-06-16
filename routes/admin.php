<?php

use App\Modules\Admin\Http\Controllers\AdminDashboardController;
use App\Modules\Admin\Http\Middleware\EnsureAdminShellAccessible;
use Illuminate\Support\Facades\Route;

Route::prefix(config('admin.path', 'admin'))
    ->name('admin.')
    ->middleware(EnsureAdminShellAccessible::class)
    ->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
    });
