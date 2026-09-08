<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
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
        Paginator::useTailwind();

        RateLimiter::for('login', function (Request $request) {
            $phone = preg_replace('/\D+/', '', (string) $request->input('nomor_telepon'));

            return [
                Limit::perMinute(5)->by('login:'.hash('sha256', $phone.'|'.$request->ip())),
                Limit::perMinute(20)->by('login-ip:'.$request->ip()),
            ];
        });

        RateLimiter::for('register', function (Request $request) {
            $phone = preg_replace('/\D+/', '', (string) $request->input('nomor_telepon'));

            return [
                Limit::perMinute(5)->by('register-ip:'.$request->ip()),
                Limit::perHour(3)->by('register:'.hash('sha256', $phone.'|'.$request->ip())),
            ];
        });
    }
}
