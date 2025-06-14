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
use App\Http\Controllers\Admin\SponsorController as AdminSponsorController;
use App\Http\Controllers\Admin\KhitanRegistrationController as AdminKhitanRegistrationController;


// User Controller
use App\Http\Controllers\User\DashboardController as UserDashboardController;

// Khitan User Controller
use App\Http\Controllers\KhitanDashboardController as KhitanUserDashboardController;

// Helper Controller
use App\Http\Controllers\HelperController;

// Models
use App\Models\Competition;
use App\Models\Sponsor;

use App\Exports\KhitanRegistrationExport;
use Maatwebsite\Excel\Facades\Excel;


Route::get('/', function () {
    $viewData = [
        'title' => 'Home',
        'description' => 'Welcome to the home page.',
        'competitions' => Competition::where('status', 'open')->latest()->get(),
        'sponsors' => Sponsor::all(),
    ];
    return view('welcome', $viewData);
});
Route::get('/image/{path}', [HelperController::class, 'getImage'])->name('get.image');
Route::get('/group/getAllGroups', [AdminGroupController::class, 'getAllGroups'])->name('group.getAllGroups');
Route::get('/group/getGroupByName', [AdminGroupController::class, 'getGroupByName'])->name('group.getGroupByName');
Route::get('/register/khitan', [KhitanUserDashboardController::class, 'registration'])->name('khitan.registration');
Route::get('/register/khitan/person', [KhitanUserDashboardController::class, 'registerPerson'])->name('khitan.registration.person');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/register/khitan/person', [KhitanUserDashboardController::class, 'registerPersonStore'])->name('khitan.registration.person.store');
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin-dashboard/search', [AdminDashboardController::class, 'search'])->name('admin.dashboard.search');
    Route::get('/admin-dashboard/search/khitan', [AdminDashboardController::class, 'searchKhitan'])->name('admin.dashboard.search-khitan');

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
    Route::get('/admin-dashboard/registration/{id}', [AdminRegistrationController::class, 'detail'])->name('admin.dashboard.registration.detail');
    Route::get('/admin-dashboard/registration/edit/{id}', [AdminRegistrationController::class, 'edit'])->name('admin.dashboard.registration.edit');
    Route::put('/admin-dashboard/registration/update', [AdminRegistrationController::class, 'update'])->name('admin.dashboard.registration.update');

    // Admin Khitanan Registration Route
    Route::get('/admin-dashboard/khitan-registration', [AdminKhitanRegistrationController::class, 'index'])->name('admin.dashboard.khitan-registration');
    Route::get('/admin-dashboard/khitan-registration/create', [AdminKhitanRegistrationController::class, 'create'])->name('admin.dashboard.khitan-registration.create');
    Route::post('/admin-dashboard/khitan-registration/store', [AdminKhitanRegistrationController::class, 'store'])->name('admin.dashboard.khitan-registration.store');
    Route::get('/admin-dashboard/khitan-registration/edit/{id}', [AdminKhitanRegistrationController::class, 'edit'])->name('admin.dashboard.khitan-registration.edit');
    Route::put('/admin-dashboard/khitan-registration/update/{id}', [AdminKhitanRegistrationController::class, 'update'])->name('admin.dashboard.khitan-registration.update');
    Route::delete('/admin-dashboard/khitan-registration/delete', [AdminKhitanRegistrationController::class, 'destroy'])->name('admin.dashboard.khitan-registration.destroy');


    // Admin Check In Route
    Route::get('/admin-dashboard/check-in', [AdminCheckInController::class, 'index'])->name('admin.dashboard.check-in');
    Route::get('/admin-dashboard/check-in/{id}', [AdminCheckInController::class, 'detail'])->name('admin.dashboard.check-in.detail');
    Route::post('/admin-dashboard/check-in/store', [AdminCheckInController::class, 'checkin'])->name('admin.dashboard.check-in.store');
    Route::post('/admin-dashboard/check-in/store/qr', [AdminCheckInController::class, 'checkinQR'])->name('admin.dashboard.check-in.store.qr');
    // Admin Sponsor Route
    Route::get('/admin-dashboard/sponsor', [AdminSponsorController::class, 'index'])->name('admin.dashboard.sponsor');
    Route::get('/admin-dashboard/sponsor/create', [AdminSponsorController::class, 'create'])->name('admin.dashboard.sponsor.create');
    Route::post('/admin-dashboard/sponsor/store', [AdminSponsorController::class, 'store'])->name('admin.dashboard.sponsor.store');
    Route::get('/admin-dashboard/sponsor/edit/{id}', [AdminSponsorController::class, 'edit'])->name('admin.dashboard.sponsor.edit');
    Route::put('/admin-dashboard/sponsor/update', [AdminSponsorController::class, 'update'])->name('admin.dashboard.sponsor.update');
    Route::delete('/admin-dashboard/sponsor/delete', [AdminSponsorController::class, 'destroy'])->name('admin.dashboard.sponsor.destroy');

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

    // Khitan User Route
    Route::get('/khitan-dashboard', [KhitanUserDashboardController::class, 'index'])->name('khitan.dashboard');
    Route::get('/khitan-dashboard/qr/{id}', [KhitanUserDashboardController::class, 'khitanRegistrationQR'])->name('khitan.registration.qr-code');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/export/khitan-registrations', function () {
    return Excel::download(new KhitanRegistrationExport, 'khitan_registrations.xlsx');
})->name('khitan-registrations.export');

require __DIR__ . '/auth.php';
