<?php

use App\Modules\Installer\Http\Controllers\InstallerController;
use Illuminate\Support\Facades\Route;

Route::prefix('install')
    ->name('installer.')
    ->group(function (): void {
        Route::get('/', [InstallerController::class, 'show'])->name('show');
        Route::post('/lock', [InstallerController::class, 'lock'])->name('lock');
    });
