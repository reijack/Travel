<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \View::composer('*', function ($view) {
            $view->with('sidebarTrips', \App\Models\Trip::latest()->take(5)->get());
        });
    }
}