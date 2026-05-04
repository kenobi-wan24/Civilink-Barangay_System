<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Resident as ResidentCtrl;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\RegisteredResidentController;

// ─── Public website ────────────────────────────────────────
Route::get('/',              [PublicController::class, 'home'])->name('home');
Route::get('/about',         [PublicController::class, 'about'])->name('about');
Route::get('/officials',     [PublicController::class, 'officials'])->name('officials');
Route::get('/announcements', [PublicController::class, 'announcements'])->name('announcements');
Route::get('/contact',       [PublicController::class, 'contact'])->name('contact');
Route::post('/contact',      [PublicController::class, 'storeInquiry'])->name('contact.store');

// ─── Auth ──────────────────────────────────────────────────
require __DIR__.'/auth.php';

Route::post('/register/resident', [RegisteredResidentController::class, 'store'])
    ->name('register.resident');

// ─── Admin panel ───────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('dashboard');

    // Residents
    Route::resource('residents', Admin\ResidentController::class);
    Route::patch('residents/{resident}/reactivate',
        [Admin\ResidentController::class, 'reactivate'])
        ->name('residents.reactivate');

    // Document types
    Route::resource('document-types', Admin\DocumentTypeController::class);

    // Document requests
    Route::resource('document-requests', Admin\DocumentRequestController::class)
        ->only(['index', 'show']);
    Route::patch('document-requests/{documentRequest}/approve',
        [Admin\DocumentRequestController::class, 'approve'])
        ->name('document-requests.approve');
    Route::patch('document-requests/{documentRequest}/reject',
        [Admin\DocumentRequestController::class, 'reject'])
        ->name('document-requests.reject');
    Route::patch('document-requests/{documentRequest}/release',
        [Admin\DocumentRequestController::class, 'release'])
        ->name('document-requests.release');
    Route::get('document-requests/{documentRequest}/preview',
        [Admin\DocumentRequestController::class, 'preview'])
        ->name('document-requests.preview');

    Route::get('document-requests/{documentRequest}/inline',
        [Admin\DocumentRequestController::class, 'inline'])
        ->name('document-requests.inline');

    // Announcements
    Route::resource('announcements', Admin\AnnouncementController::class);

    // Officials
    Route::resource('officials', Admin\OfficialController::class);

    // Inquiries
    Route::resource('inquiries', Admin\InquiryController::class)
        ->only(['index', 'show', 'update']);

    // Users & account management
    Route::get('/users',               [Admin\UserController::class, 'index'])
        ->name('users.index');
    Route::get('/users/create',        [Admin\UserController::class, 'create'])
        ->name('users.create');
    Route::post('/users',              [Admin\UserController::class, 'store'])
        ->name('users.store');
    Route::delete('/users/{user}',     [Admin\UserController::class, 'destroy'])
        ->name('users.destroy');
    Route::post('/users/{user}/link',  [Admin\UserController::class, 'linkAccount'])
        ->name('users.link');
});

// ─── Resident portal ───────────────────────────────────────
Route::prefix('portal')->name('resident.')->middleware(['auth', 'resident'])->group(function () {

    Route::get('/dashboard', function () {
        return view('resident.dashboard');
    })->name('dashboard');

    Route::get('/request',  [ResidentCtrl\PortalController::class, 'requestForm'])
        ->name('request.form');
    Route::post('/request', [ResidentCtrl\PortalController::class, 'submitRequest'])
        ->name('request.submit');
    Route::get('/my-requests', [ResidentCtrl\PortalController::class, 'myRequests'])
        ->name('my-requests');
        
    Route::get('/requests/{documentRequest}/download',
    [ResidentCtrl\PortalController::class, 'viewDocument'])
    ->name('request.download');
});