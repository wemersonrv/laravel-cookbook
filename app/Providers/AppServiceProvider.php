<?php

namespace App\Providers;

use App\Models\Announcement;
use Illuminate\Support\Facades\Http;
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
        view()->composer('layouts.app-layout', function($view) {
            $announcement = Announcement::first();

            $view->with([
                'bannerText' => $announcement?->banner_text,
                'bannerColor' => $announcement?->banner_color,
                'isActive' => $announcement?->is_active,
            ]);
        });

        Http::macro('movies', function () {
            return Http::withHeaders([
              'X-Example' => 'example',
            ])->withToken(config('services.tmdb.bearerToken'))
              ->baseUrl('https://api.themoviedb.org/3');
        });
    }
}
