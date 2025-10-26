<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        Paginator::useBootstrap();
    }

    
    public function boot(): void
    {
        //
    }
}
