<?php

namespace App\Providers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $logo = 'logo.png';
        $logoUrl = Storage::disk('s3')->url($logo);
        View::share('logoUrl', $logoUrl);
    }
}
