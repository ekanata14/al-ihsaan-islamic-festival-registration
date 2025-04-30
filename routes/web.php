<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controlleraaaaaaaaaaa
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;

// User Controller
use App\Http\Controllers\User\DashboardController as UserDashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin-dashboard/group/getGroupByName', [AdminGroupController::class, 'getGroupByName'])->name('admin.dashboard.group.getGroupByName');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Admin User Route
    Route::get('/admin-dashboard/user', [AdminUserController::class, 'index'])->name('admin.dashboard.user');
    Route::get('/admin-dashboard/user/create', [AdminUserController::class, 'create'])->name('admin.dashboard.user.create');

    // Admin Group Route
    Route::get('/admin-dashboard/group', [AdminGroupController::class, 'index'])->name('admin.dashboard.group');
    Route::get('/admin-dashboard/group/create', [AdminGroupController::class, 'create'])->name('admin.dashboard.group.create');
    Route::post('/admin-dashboard/group/store', [AdminGroupController::class, 'store'])->name('admin.dashboard.group.store');
    Route::get('/admin-dashboard/group/edit/{id}', [AdminGroupController::class, 'edit'])->name('admin.dashboard.group.edit');
    Route::put('/admin-dashboard/group/update', [AdminGroupController::class, 'update'])->name('admin.dashboard.group.update');
    Route::delete('/admin-dashboard/group/delete', [AdminGroupController::class, 'destroy'])->name('admin.dashboard.group.destroy');

    // User Route
    Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
