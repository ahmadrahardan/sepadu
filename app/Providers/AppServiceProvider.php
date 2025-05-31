<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

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
        // dd($this->app->environment());

        if($this->app->environment('railway')){
            URL::forceScheme('https');
        }
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}
