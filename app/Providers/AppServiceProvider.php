<?php

namespace App\Providers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
// use Barryvdh\DomPDF\Facade as PDF;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\Barryvdh\DomPDF\ServiceProvider::class);
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
