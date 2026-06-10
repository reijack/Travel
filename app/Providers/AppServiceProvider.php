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
    // ✅ Hanya view yang extend 'layouts.app'
    \View::composer('layouts.app', function ($view) {
        $view->with('sidebarTrips', \App\Models\Trip::latest()->take(5)->get());
    });
 }
}