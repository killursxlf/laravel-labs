<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:check-overdue-tasks')
    ->dailyAt('08:00')
    ->onSuccess(function () {
        \Log::channel('scheduler')->info('check-overdue-tasks done');
    })
    ->onFailure(function () {
        \Log::channel('scheduler')->error('check-overdue-tasks failed');
    });

Schedule::command('app:generate-report')
    ->weeklyOn(1, '09:00')
    ->onSuccess(function () {
        \Log::channel('scheduler')->info('generate-report done');
    })
    ->onFailure(function () {
        \Log::channel('scheduler')->error('generate-report failed');
    });
