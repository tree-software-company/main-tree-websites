<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingPageList;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogOut;
use App\Http\Controllers\AdminController;

Route::get('/', [HomepageController::class, 'index']);

Route::get('/en-us', function () {
    return redirect('/');
});

Auth::routes();

Route::get('/logout', [LogOut::class, 'logout'])->name('logout');

Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update', [UserController::class, 'update'])->name('user.update');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/form-website/status', [AdminController::class, 'updateFormWebsiteStatus'])->name('admin.updateFormWebsiteStatus');
Route::post('/admin/send-email', [AdminController::class, 'sendEmailToUser'])->name('admin.sendEmail');
Route::post('/admin/update-password', [AdminController::class, 'updateUserPassword'])->name('admin.updateUserPassword');

Route::get('/en-us/{slug}', function ($slug) {
    return redirect("/$slug", 301);
})->where('slug', '.*');

Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');

Route::post('/register-product', [LandingPageList::class, 'submitForm'])->name('register-product.submit')->where('url', '.*');

Route::get('/{url}', [PagesController::class, 'show'])->where('url', '.*');

// Fallback route in case of invalid locale
Route::fallback(function () {
    return redirect('/');
});
