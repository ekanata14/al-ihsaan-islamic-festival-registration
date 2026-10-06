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
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\LandingBlockController as AdminLandingBlockController;
use App\Http\Controllers\Admin\LandingSettingController as AdminLandingSettingController;
use App\Http\Controllers\Admin\ContactPersonController as AdminContactPersonController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;


// Landing Controller
use App\Http\Controllers\LandingController;


// User Controller
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;

// Khitan User Controller
use App\Http\Controllers\KhitanDashboardController as KhitanUserDashboardController;

// Helper Controller
use App\Http\Controllers\HelperController;

// Notification Controller
use App\Http\Controllers\NotificationController;

use App\Exports\KhitanRegistrationExport;
use App\Exports\VerifiedParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;


Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/image/{path}', [HelperController::class, 'getImage'])->where('path', '.*')->name('get.image');
Route::get('/group/getAllGroups', [AdminGroupController::class, 'getAllGroups'])->name('group.getAllGroups');
Route::get('/group/getGroupByName', [AdminGroupController::class, 'getGroupByName'])->name('group.getGroupByName');
Route::get('/register/khitan', [KhitanUserDashboardController::class, 'registration'])->name('khitan.registration');
Route::get('/register/khitan/person', [KhitanUserDashboardController::class, 'registerPerson'])->name('khitan.registration.person');


Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin-dashboard/search', [AdminDashboardController::class, 'search'])->name('admin.dashboard.search');
    Route::get('/admin-dashboard/search/khitan', [AdminDashboardController::class, 'searchKhitan'])->name('admin.dashboard.search-khitan');

    // Admin User Route
    Route::get('/admin-dashboard/user', [AdminUserController::class, 'index'])->name('admin.dashboard.user');
    Route::get('/admin-dashboard/user/create', [AdminUserController::class, 'create'])->name('admin.dashboard.user.create');
    Route::post('/admin-dashboard/user/store', [AdminUserController::class, 'store'])->name('admin.dashboard.user.store');
    Route::get('/admin-dashboard/user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.dashboard.user.edit');
    Route::put('/admin-dashboard/user/update', [AdminUserController::class, 'update'])->name('admin.dashboard.user.update');
    Route::delete('/admin-dashboard/user/delete', [AdminUserController::class, 'destroy'])->name('admin.dashboard.user.destroy');

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
    Route::get('/admin-dashboard/registration/detail/{id}', [AdminRegistrationController::class, 'edit'])->name('admin.dashboard.registration.detail.person');
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

    // Admin Landing Page Route
    Route::prefix('admin-dashboard/landing')->name('admin.dashboard.landing.')->group(function () {
        Route::get('content', [AdminLandingBlockController::class, 'index'])->name('content');
        Route::get('content/create', [AdminLandingBlockController::class, 'create'])->name('content.create');
        Route::post('content/store', [AdminLandingBlockController::class, 'store'])->name('content.store');
        Route::get('content/edit/{id}', [AdminLandingBlockController::class, 'edit'])->name('content.edit');
        Route::put('content/update', [AdminLandingBlockController::class, 'update'])->name('content.update');
        Route::delete('content/delete', [AdminLandingBlockController::class, 'destroy'])->name('content.destroy');
        Route::post('content/reorder', [AdminLandingBlockController::class, 'reorder'])->name('content.reorder');
        Route::post('content/toggle', [AdminLandingBlockController::class, 'toggle'])->name('content.toggle');

        Route::get('settings', [AdminLandingSettingController::class, 'edit'])->name('settings');
        Route::put('settings', [AdminLandingSettingController::class, 'update'])->name('settings.update');

        Route::get('contact', [AdminContactPersonController::class, 'index'])->name('contact');
        Route::get('contact/create', [AdminContactPersonController::class, 'create'])->name('contact.create');
        Route::post('contact/store', [AdminContactPersonController::class, 'store'])->name('contact.store');
        Route::get('contact/edit/{id}', [AdminContactPersonController::class, 'edit'])->name('contact.edit');
        Route::put('contact/update', [AdminContactPersonController::class, 'update'])->name('contact.update');
        Route::delete('contact/delete', [AdminContactPersonController::class, 'destroy'])->name('contact.destroy');
    });

    // Admin Activity Log Route
    Route::get('/admin-dashboard/activity-log', [AdminActivityLogController::class, 'index'])->name('admin.dashboard.activity-log');

    // Admin Announcement Route
    Route::get('/admin-dashboard/announcement', [AdminAnnouncementController::class, 'index'])->name('admin.dashboard.announcement');
    Route::get('/admin-dashboard/announcement/create', [AdminAnnouncementController::class, 'create'])->name('admin.dashboard.announcement.create');
    Route::post('/admin-dashboard/announcement/store', [AdminAnnouncementController::class, 'store'])->name('admin.dashboard.announcement.store');
    Route::get('/admin-dashboard/announcement/edit/{id}', [AdminAnnouncementController::class, 'edit'])->name('admin.dashboard.announcement.edit');
    Route::put('/admin-dashboard/announcement/update', [AdminAnnouncementController::class, 'update'])->name('admin.dashboard.announcement.update');
    Route::delete('/admin-dashboard/announcement/delete', [AdminAnnouncementController::class, 'destroy'])->name('admin.dashboard.announcement.destroy');
    Route::post('/admin-dashboard/announcement/publish', [AdminAnnouncementController::class, 'publish'])->name('admin.dashboard.announcement.publish');

    // Admin Payment Route
    Route::get('/admin-dashboard/payment', [AdminPaymentController::class, 'index'])->name('admin.dashboard.payment');
    Route::post('/admin-dashboard/payment/bulk-verify', [AdminPaymentController::class, 'bulkVerify'])->name('admin.dashboard.payment.bulk-verify');
    Route::get('/admin-dashboard/payment/{id}', [AdminPaymentController::class, 'detail'])->name('admin.dashboard.payment.detail');
    Route::get('/admin-dashboard/payment/{id}/proof', [AdminPaymentController::class, 'proof'])->name('admin.dashboard.payment.proof');
    Route::post('/admin-dashboard/payment/{id}/verify', [AdminPaymentController::class, 'verify'])->name('admin.dashboard.payment.verify');
    Route::post('/admin-dashboard/payment/{id}/reject', [AdminPaymentController::class, 'reject'])->name('admin.dashboard.payment.reject');

    // Export Khitan Registrations
    Route::get('/export/khitan-registrations', function () {
        return Excel::download(new KhitanRegistrationExport, 'khitan_registrations.xlsx');
    })->name('khitan-registrations.export');

    // Export Peserta Terverifikasi
    Route::get('/export/verified-participants', function () {
        return Excel::download(new VerifiedParticipantsExport, 'peserta_terverifikasi.xlsx');
    })->name('verified-participants.export');
});

Route::middleware(['auth', 'verified', 'role:user,khitan'])->group(function () {
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

    // User Payment Route
    Route::get('/user-dashboard/payment', [UserPaymentController::class, 'show'])->name('user.payment');
    Route::post('/user-dashboard/payment/proof', [UserPaymentController::class, 'uploadProof'])->middleware('throttle:6,1')->name('user.payment.proof.store');
    Route::get('/user-dashboard/payment/proof', [UserPaymentController::class, 'proof'])->name('user.payment.proof.show');
    Route::get('/user-dashboard/payment/receipt', [UserPaymentController::class, 'receipt'])->name('user.payment.receipt');

    // Khitan User Route
    Route::post('/register/khitan/person', [KhitanUserDashboardController::class, 'registerPersonStore'])->name('khitan.registration.person.store');
    Route::get('/khitan-dashboard', [KhitanUserDashboardController::class, 'index'])->name('khitan.dashboard');
    Route::get('/khitan-dashboard/qr/{id}', [KhitanUserDashboardController::class, 'khitanRegistrationQR'])->name('khitan.registration.qr-code');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
