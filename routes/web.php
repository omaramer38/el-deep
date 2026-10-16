<?php

use App\Http\Controllers\Site\BlogController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\ElevatorController;
use App\Http\Controllers\Site\NewsletterController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\ServiceController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

// Root redirect based on language preference
Route::get('/', [SiteController::class, 'root'])->name('site.root');

// Public Bilingual Routes
Route::prefix('{locale}')
    ->where(['locale' => 'en|ar'])
    ->middleware(['locale'])
    ->name('site.')
    ->group(function () {
        Route::get('/', [SiteController::class, 'home'])->name('home');
        Route::get('/about', [SiteController::class, 'about'])->name('about');

        // Elevators
        Route::get('/elevators', [ElevatorController::class, 'index'])->name('elevators.index');
        Route::get('/elevators/{slug}', [ElevatorController::class, 'show'])->name('elevators.show');

        // Services
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

        // Projects
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

        // Blog
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

        // FAQ & Contact
        Route::get('/faq', [SiteController::class, 'faq'])->name('faq');
        Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
        Route::post('/contact', [ContactController::class, 'submit'])
            ->middleware([\Spatie\Honeypot\ProtectAgainstSpam::class, 'throttle:5,1'])
            ->name('contact.submit');
        Route::post('/newsletter', [NewsletterController::class, 'subscribe'])
            ->middleware([\Spatie\Honeypot\ProtectAgainstSpam::class, 'throttle:5,1'])
            ->name('newsletter.subscribe');

        // CMS Legal Pages
        Route::get('/privacy', [SiteController::class, 'privacy'])->name('privacy');
        Route::get('/terms', [SiteController::class, 'terms'])->name('terms');
    });

// Global Technical SEO routes
Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SiteController::class, 'robots'])->name('robots');

// Admin Routes
require __DIR__.'/admin.php';
