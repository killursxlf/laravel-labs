<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendTaskCreatedNotification implements ShouldQueue
{
    public function handle(TaskCreated $event)
    {
        Log::info('Task created: ' . $event->task->title . ' (ID: ' . $event->task->id . ')');
    }
}
