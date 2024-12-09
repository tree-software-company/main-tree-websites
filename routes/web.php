<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TreeForBusinessController;
use App\Http\Controllers\TreeForEducationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingPageList;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomepageController::class, 'index']);

Route::get('/en-us', function () {
    return redirect('/');
});

Auth::routes();

Route::get('/en-us/{slug}', function ($slug) {
    return redirect("/$slug", 301);
})->where('slug', '.*');

Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

Route::post('/register-product', [LandingPageList::class, 'submitForm'])->name('register-product.submit')->where('url', '.*');

// Define route for '/landing-page' without locale prefix (fallback for en-us)

Route::get('/{url}', [PagesController::class, 'show'])->where('url', '.*');

// Fallback route in case of invalid locale
Route::fallback(function () {
    return redirect('/');
});
