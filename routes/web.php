<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrequalController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\ThanksController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show')->where('slug', '[a-z0-9-]+');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/capability-statement', [PageController::class, 'capability'])->name('capability');
Route::get('/capability-statement.pdf', [PageController::class, 'capabilityPdf'])->name('capability.pdf');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/tenders', [TenderController::class, 'create'])->name('tenders.create');
Route::get('/prequalification', [PrequalController::class, 'create'])->name('prequal.create');
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::get('/careers/apply', [CareerController::class, 'create'])->name('careers.apply');
Route::get('/careers/{job}', [CareerController::class, 'show'])->name('careers.show');

Route::middleware('throttle:forms')->group(function () {
    Route::post('/tenders', [TenderController::class, 'store'])->name('tenders.store');
    Route::post('/prequalification', [PrequalController::class, 'store'])->name('prequal.store');
    Route::post('/careers/apply', [CareerController::class, 'store'])->name('careers.store');
    Route::post('/contact', [EnquiryController::class, 'store'])->name('contact.store');
});
Route::get('/thanks', ThanksController::class)->name('thanks');

// Signed links only: certificate renewals (emailed to vendors) and client document rooms.
Route::middleware('signed')->group(function () {
    Route::get('/prequalification/{vendor}/renew', [PrequalController::class, 'renew'])->name('prequal.renew');
    Route::post('/prequalification/{vendor}/renew', [PrequalController::class, 'storeRenewal'])->middleware('throttle:forms')->name('prequal.renew.store');
    Route::get('/project-documents/{room}/{key}', [RoomController::class, 'show'])->name('rooms.show');
    Route::get('/project-documents/{room}/{key}/{document}', [RoomController::class, 'download'])->name('rooms.download');
});

Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/photo-credits', [PageController::class, 'credits'])->name('credits');
Route::get('/sitemap', [PageController::class, 'sitemapPage'])->name('sitemap.page');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

// Addresses from the old Squarespace site (Wayback Machine, 2022) that may still be bookmarked.
foreach ((array) config('ypseaton.legacy_redirects', []) as $from => $to) {
    Route::permanentRedirect($from, $to);
}

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'active'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::middleware('area:tenders')->group(function () {
        Route::get('/tenders', [Admin\TenderController::class, 'index'])->name('tenders.index');
        Route::get('/tenders/export', [Admin\TenderController::class, 'export'])->name('tenders.export');
        Route::get('/tenders/{tender}', [Admin\TenderController::class, 'show'])->name('tenders.show');
        Route::patch('/tenders/{tender}', [Admin\TenderController::class, 'update'])->name('tenders.update');
        Route::post('/tenders/{tender}/notes', [Admin\TenderController::class, 'note'])->name('tenders.note');
        Route::get('/tenders/{tender}/files/{file}', [Admin\TenderController::class, 'file'])->name('tenders.file');
    });

    Route::middleware('area:prequal')->group(function () {
        Route::get('/vendors', [Admin\VendorController::class, 'index'])->name('vendors.index');
        Route::get('/vendors/export', [Admin\VendorController::class, 'export'])->name('vendors.export');
        Route::get('/vendors/{vendor}', [Admin\VendorController::class, 'show'])->name('vendors.show');
        Route::patch('/vendors/{vendor}', [Admin\VendorController::class, 'update'])->name('vendors.update');
        Route::post('/vendors/{vendor}/notes', [Admin\VendorController::class, 'note'])->name('vendors.note');
        Route::get('/vendors/{vendor}/documents/{document}', [Admin\VendorController::class, 'document'])->name('vendors.document');
        Route::patch('/vendors/{vendor}/documents/{document}', [Admin\VendorController::class, 'verify'])->name('vendors.verify');
    });

    Route::middleware('area:careers')->group(function () {
        Route::get('/jobs', [Admin\JobPostingController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [Admin\JobPostingController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [Admin\JobPostingController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [Admin\JobPostingController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [Admin\JobPostingController::class, 'update'])->name('jobs.update');
        Route::get('/applications', [Admin\ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/export', [Admin\ApplicationController::class, 'export'])->name('applications.export');
        Route::get('/applications/{application}', [Admin\ApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}', [Admin\ApplicationController::class, 'update'])->name('applications.update');
        Route::post('/applications/{application}/notes', [Admin\ApplicationController::class, 'note'])->name('applications.note');
        Route::get('/applications/{application}/cv', [Admin\ApplicationController::class, 'cv'])->name('applications.cv');
    });

    Route::middleware('area:enquiries')->group(function () {
        Route::get('/enquiries', [Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('/enquiries/{enquiry}', [Admin\EnquiryController::class, 'show'])->name('enquiries.show');
        Route::patch('/enquiries/{enquiry}', [Admin\EnquiryController::class, 'update'])->name('enquiries.update');
    });

    Route::middleware('area:rooms')->group(function () {
        Route::get('/rooms', [Admin\RoomController::class, 'index'])->name('rooms.index');
        Route::post('/rooms', [Admin\RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/{room}', [Admin\RoomController::class, 'show'])->name('rooms.show');
        Route::patch('/rooms/{room}', [Admin\RoomController::class, 'update'])->name('rooms.update');
        Route::post('/rooms/{room}/documents', [Admin\RoomController::class, 'upload'])->name('rooms.upload');
        Route::get('/rooms/{room}/documents/{document}', [Admin\RoomController::class, 'download'])->name('rooms.download');
        Route::delete('/rooms/{room}/documents/{document}', [Admin\RoomController::class, 'destroyDocument'])->name('rooms.documents.destroy');
        Route::post('/rooms/{room}/share', [Admin\RoomController::class, 'share'])->name('rooms.share');
        Route::post('/rooms/{room}/revoke', [Admin\RoomController::class, 'revoke'])->name('rooms.revoke');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    });
});
