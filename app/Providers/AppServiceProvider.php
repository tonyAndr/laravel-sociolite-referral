<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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
    public function boot()
    {
        // if(env('APP_ENV', 'production') == 'production') { // use https only if env is production
        //     URL::forceScheme('https');
        // }
    }
}
