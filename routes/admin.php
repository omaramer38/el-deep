<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\ArticleCategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ElevatorCategoryController;
use App\Http\Controllers\Admin\ElevatorController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectCategoryController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StyleguideController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'locale'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/switch-locale/{locale}', [DashboardController::class, 'switchLocale'])->name('switch-locale');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/logout-other-devices', [ProfileController::class, 'logoutOtherDevices'])->name('profile.logout-other-devices');
    Route::get('/two-factor-setup', [ProfileController::class, 'twoFactorSetup'])->name('two-factor.setup');

    Route::get('/styleguide', [StyleguideController::class, 'index'])->name('styleguide');

    // Elevators & Categories
    Route::middleware('permission:elevators.delete')->delete('elevators/{elevator}/media/{media}', [ElevatorController::class, 'destroyMedia'])->name('elevators.media.destroy');
    Route::middleware('permission:elevators.delete')->delete('elevators/{elevator}', [ElevatorController::class, 'destroy'])->name('elevators.destroy');
    Route::middleware('permission:elevators.create')->group(function () {
        Route::get('elevators/create', [ElevatorController::class, 'create'])->name('elevators.create');
        Route::post('elevators', [ElevatorController::class, 'store'])->name('elevators.store');
    });
    Route::middleware('permission:elevators.edit')->group(function () {
        Route::get('elevators/{elevator}/edit', [ElevatorController::class, 'edit'])->name('elevators.edit');
        Route::match(['put', 'patch'], 'elevators/{elevator}', [ElevatorController::class, 'update'])->name('elevators.update');
        Route::resource('elevator-categories', ElevatorCategoryController::class)->except(['create', 'edit', 'show']);
        Route::resource('catalogues', CatalogueController::class);
    });
    Route::middleware('permission:elevators.view')->group(function () {
        Route::get('elevators', [ElevatorController::class, 'index'])->name('elevators.index');
        Route::get('elevators/{elevator}', [ElevatorController::class, 'show'])->name('elevators.show');
    });

    // Projects & Categories
    Route::middleware('permission:projects.delete')->delete('projects/{project}/media/{media}', [ProjectController::class, 'destroyMedia'])->name('projects.media.destroy');
    Route::middleware('permission:projects.delete')->delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::middleware('permission:projects.create')->group(function () {
        Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    });
    Route::middleware('permission:projects.edit')->group(function () {
        Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::match(['put', 'patch'], 'projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::resource('project-categories', ProjectCategoryController::class)->except(['create', 'edit', 'show']);
    });
    Route::middleware('permission:projects.view')->group(function () {
        Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    });

    // Services
    Route::middleware('permission:services.delete')->delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::middleware('permission:services.create')->group(function () {
        Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('services', [ServiceController::class, 'store'])->name('services.store');
    });
    Route::middleware('permission:services.edit')->group(function () {
        Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::match(['put', 'patch'], 'services/{service}', [ServiceController::class, 'update'])->name('services.update');
    });
    Route::middleware('permission:services.view')->group(function () {
        Route::get('services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');
    });

    // Blog & Categories
    Route::middleware('permission:blog.delete')->delete('blog/{article}', [ArticleController::class, 'destroy'])->name('blog.destroy');
    Route::middleware('permission:blog.create')->group(function () {
        Route::get('blog/create', [ArticleController::class, 'create'])->name('blog.create');
        Route::post('blog', [ArticleController::class, 'store'])->name('blog.store');
    });
    Route::middleware('permission:blog.edit')->group(function () {
        Route::get('blog/{article}/edit', [ArticleController::class, 'edit'])->name('blog.edit');
        Route::match(['put', 'patch'], 'blog/{article}', [ArticleController::class, 'update'])->name('blog.update');
        Route::resource('blog-categories', ArticleCategoryController::class)->parameters(['blog-categories' => 'articleCategory'])->except(['create', 'edit', 'show']);
    });
    Route::middleware('permission:blog.view')->group(function () {
        Route::get('blog', [ArticleController::class, 'index'])->name('blog.index');
        Route::get('blog/{article}', [ArticleController::class, 'show'])->name('blog.show');
    });

    // Messages
    Route::middleware('permission:messages.view')->group(function () {
        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::get('messages/{message}/download', [ContactMessageController::class, 'downloadAttachment'])->name('messages.download');
    });
    Route::middleware('permission:messages.manage')->group(function () {
        Route::match(['put', 'patch'], 'messages/{message}', [ContactMessageController::class, 'update'])->name('messages.update');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');
    });

    // Pages & Sections Editor
    Route::middleware('permission:pages.view')->get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::middleware('permission:pages.edit')->group(function () {
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::match(['put', 'patch'], 'pages/{page}', [PageController::class, 'update'])->name('pages.update');
    });

    // Testimonials, Partners, FAQs
    Route::middleware('permission:testimonials.view')->get('testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::middleware('permission:testimonials.manage')->group(function () {
        Route::get('testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::get('testimonials/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::match(['put', 'patch'], 'testimonials/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    });

    Route::middleware('permission:partners.view')->get('partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::middleware('permission:partners.manage')->group(function () {
        Route::post('partners', [PartnerController::class, 'store'])->name('partners.store');
        Route::match(['put', 'patch'], 'partners/{partner}', [PartnerController::class, 'update'])->name('partners.update');
        Route::delete('partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');
    });

    Route::middleware('permission:faqs.view')->get('faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::middleware('permission:faqs.manage')->group(function () {
        Route::get('faqs/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::post('faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
        Route::match(['put', 'patch'], 'faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
    });

    // Media Library
    Route::get('/media', [MediaController::class, 'index'])->middleware('permission:media.view')->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->middleware('permission:media.manage')->name('media.store');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->middleware('permission:media.manage')->name('media.destroy');
    Route::post('/media/folder', [MediaController::class, 'storeFolder'])->middleware('permission:media.manage')->name('media.folder.store');
    Route::delete('/media/folder/{folder}', [MediaController::class, 'destroyFolder'])->middleware('permission:media.manage')->name('media.folder.destroy');

    // Users (requires users permissions)
    Route::middleware('permission:users.view')->get('users', [UserController::class, 'index'])->name('users.index');
    Route::middleware('permission:users.create')->group(function () {
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
    });
    Route::middleware('permission:users.edit')->group(function () {
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::match(['put', 'patch'], 'users/{user}', [UserController::class, 'update'])->name('users.update');
    });
    Route::middleware('permission:users.delete')->delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Roles (strictly Super Admin only)
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('roles', RoleController::class);
    });

    // Activity Log
    Route::get('/activity', [ActivityController::class, 'index'])->middleware('permission:activity.view')->name('activity.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->middleware('permission:settings.view')->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->middleware('permission:settings.manage')->name('settings.update');
});
