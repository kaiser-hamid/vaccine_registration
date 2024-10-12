<?php

use App\Tasks\DistributeVaccinee;
use App\Tasks\EmailScheduleTask;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule){
        $schedule->call(EmailScheduleTask::class)->daily()->at('21:00');
        //$schedule->call(DistributeVaccinee::class)->twiceDailyAt('12:00', '23:59');
        $schedule->call(DistributeVaccinee::class)->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
