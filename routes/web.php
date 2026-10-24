<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tables CRUD
    Route::resource('tables', TableController::class)->except(['show']);

    // Users CRUD
    Route::resource('users', UserController::class)->except(['show']);

    // Roles & Permissions CRUD
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::post('permissions', [RoleController::class, 'storePermission'])->name('permissions.store');
    Route::delete('permissions/{permission}', [RoleController::class, 'destroyPermission'])->name('permissions.destroy');
});
