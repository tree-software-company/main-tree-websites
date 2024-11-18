<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $logo = 'logo.png';
            $logoUrl = Storage::disk('s3')->url($logo);
            $view->with('logoUrl', $logoUrl);
        });
    }
}
