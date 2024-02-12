<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Referral;
use Illuminate\Http\Request;

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
    // public function boot()
    // {
    //     Request::macro('referral', function ($token) {
    //         return Referral::whereToken($token)
    //                 ->whereNotCompleted()
    //                 ->whereNotFromUser(request()->user())
    //                 ->first();
    //     });
    // }
}
