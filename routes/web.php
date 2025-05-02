<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controlleraaaaaaaaaaa
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CompetitionController as AdminCompetitionController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\CheckInController as AdminCheckInController;

// User Controller
use App\Http\Controllers\User\DashboardController as UserDashboardController;

// Helper Controller
use App\Http\Controllers\HelperController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/image/{path}', [HelperController::class, 'getImage'])->name('get.image');
Route::get('/group/getAllGroups', [AdminGroupController::class, 'getAllGroups'])->name('group.getAllGroups');
Route::get('/group/getGroupByName', [AdminGroupController::class, 'getGroupByName'])->name('group.getGroupByName');

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

    // Admin Category Route
    Route::get('/admin-dashboard/category', [AdminCategoryController::class, 'index'])->name('admin.dashboard.category');
    Route::get('/admin-dashboard/category/create', [AdminCategoryController::class, 'create'])->name('admin.dashboard.category.create');
    Route::post('/admin-dashboard/category/store', [AdminCategoryController::class, 'store'])->name('admin.dashboard.category.store');
    Route::get('/admin-dashboard/category/edit/{id}', [AdminCategoryController::class, 'edit'])->name('admin.dashboard.category.edit');
    Route::put('/admin-dashboard/category/update', [AdminCategoryController::class, 'update'])->name('admin.dashboard.category.update');
    Route::delete('/admin-dashboard/category/delete', [AdminCategoryController::class, 'destroy'])->name('admin.dashboard.category.destroy');

    // Admin Competition Route
    Route::get('/admin-dashboard/competition', [AdminCompetitionController::class, 'index'])->name('admin.dashboard.competition');
    Route::get('/admin-dashboard/competition/create', [AdminCompetitionController::class, 'create'])->name('admin.dashboard.competition.create');
    Route::post('/admin-dashboard/competition/store', [AdminCompetitionController::class, 'store'])->name('admin.dashboard.competition.store');
    Route::get('/admin-dashboard/competition/edit/{id}', [AdminCompetitionController::class, 'edit'])->name('admin.dashboard.competition.edit');
    Route::put('/admin-dashboard/competition/update', [AdminCompetitionController::class, 'update'])->name('admin.dashboard.competition.update');
    Route::delete('/admin-dashboard/competition/delete', [AdminCompetitionController::class, 'destroy'])->name('admin.dashboard.competition.destroy');

    // Admin Registration Route
    Route::get('/admin-dashboard/registration', [AdminRegistrationController::class, 'index'])->name('admin.dashboard.registration');
    Route::get('/admin-dashboard/registration/edit/{id}', [AdminRegistrationController::class, 'edit'])->name('admin.dashboard.registration.edit');
    Route::put('/admin-dashboard/registration/update', [AdminRegistrationController::class, 'update'])->name('admin.dashboard.registration.update');

    // Admin Check In Route
    Route::get('/admin-dashboard/check-in', [AdminCheckInController::class, 'index'])->name('admin.dashboard.check-in');
    Route::post('/admin-dashboard/check-in/store', [AdminCheckInController::class, 'checkin'])->name('admin.dashboard.check-in.store');

    // User Route
    Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user-dashboard/registration', [UserDashboardController::class, 'index'])->name('user.dashboard.registration');
    Route::get('/user-dashboard/competitions/{id}', [UserDashboardController::class, 'getCompetitionByCategory'])->name('user.dashboard.competitions.category');
    Route::get('/user-dashboard/competitions/detail/{id}', [UserDashboardController::class, 'competitionDetail'])->name('user.dashboard.competitions.detail');
    Route::get('/user-dashboard/competitions/registration/{id}', [UserDashboardController::class, 'competitionRegistration'])->name('user.dashboard.competitions.registration'); 
    Route::get('/user-dashboard/registrations/', [UserDashboardController::class, 'registeredParticipants'])->name('user.participants');
    Route::get('/user-dashboard/registrations/detail/{id}', [UserDashboardController::class, 'competitionRegistrationDetail'])->name('user.participants.detail');
    Route::get('/user-dashboard/registrations/qr/{id}', [UserDashboardController::class, 'competitionRegistrationQR'])->name('user.participants.qr-code');
    Route::post('/user-dashboard/competitions/registration/store', [UserDashboardController::class, 'competitionRegistrationStore'])->name('user.dashboard.competitions.registration.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
