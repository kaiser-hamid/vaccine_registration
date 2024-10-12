<?php

namespace App\Providers;

use App\Contracts\NotificationContract;
use App\Services\EmailService;
use App\Services\UserNotificationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationContract::class, function ($app){
            return new UserNotificationService([
                new EmailService()
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
