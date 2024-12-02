<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TreeForBusinessController;
use App\Http\Controllers\TreeForEducationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomepageController::class, 'index']);

Route::get('/en-us', function () {
    return redirect('/');
});

Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

Auth::routes();

Route::get('/en-us/{slug}', function ($slug) {
    // Tworzymy przekierowanie na nową ścieżkę bez "en-us"
    return redirect("/$slug", 301); // Używamy kodu HTTP 301 dla permanentnego przekierowania
})->where('slug', '.*');

// Define route for '/landing-page' without locale prefix (fallback for en-us)
Route::get('/{url}', [LandingPageController::class, 'show'])->where('url', '.*');

// Fallback route in case of invalid locale
Route::fallback(function () {
    return redirect('/');
});
