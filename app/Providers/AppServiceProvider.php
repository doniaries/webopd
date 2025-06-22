<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use App\Models\Post;
use App\Observers\PostObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\App\Providers\FormatServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            app()->setLocale('id');
        });
        
        // Mendaftarkan observer
        Post::observe(PostObserver::class);
    }
}
