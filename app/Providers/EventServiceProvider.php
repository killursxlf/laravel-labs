<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\TaskCreated::class => [
            \App\Listeners\SendTaskCreatedNotification::class,
        ],
    ];


    public function boot(): void
    {
        //
    }
}
