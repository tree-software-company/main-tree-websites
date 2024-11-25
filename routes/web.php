<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TreeForBusinessController;
use App\Http\Controllers\TreeForEducationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RegionController; 

// Define route for '/landing-page' without locale prefix (this is the homepage without a locale prefix)
Route::get('/', function () {
    return view('welcome');
});

// Define route for '/landing-page' without locale prefix (fallback for en-us)

Route::get('/business', [TreeForBusinessController::class, 'index']);

Route::get('/education', [TreeForEducationController::class, 'index']);

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/legal', [LegalController::class, 'show'])->name('legal.show');
Route::get('/legal/privacy', [LegalController::class, 'privacyPolicy'])->name('legal.privacy');

Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/choose-country-region', [RegionController::class, 'index']);

// Authentication Routes
Auth::routes();

Route::get('/{url}', [LandingPageController::class, 'show'])->name('landing-page');

// Route group for locale-prefixed routes (this is where the locale comes in)
Route::group(['prefix' => '{locale}', 'middleware' => 'setLocale'], function () {
    // Route for homepage with locale prefix
    Route::get('/', function () {
        return view('welcome');
    });

    // Route for '/landing-page' with locale prefix

    Route::get('/business', [TreeForBusinessController::class, 'index']);

    Route::get('/education', [TreeForEducationController::class, 'index']);

    Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

    Route::get('/legal', [LegalController::class, 'show'])->name('legal.show');
    Route::get('/legal/privacy', [LegalController::class, 'privacyPolicy'])->name('legal.privacy');

    Route::get('/sitemap', [SitemapController::class, 'index'])->name('sitemap');

    Route::get('/choose-country-region', [RegionController::class, 'index']);
});

// Fallback route in case of invalid locale
Route::fallback(function () {
    return redirect('/');
});
