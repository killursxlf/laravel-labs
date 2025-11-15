<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Jobs\SendTelegramMessageJob;
use Illuminate\Support\Facades\Log;

class SendTaskCreatedTelegramNotification
{
    public function handle(TaskCreated $event): void
    {
        $task = $event->task;

        $text = sprintf(
            "New task:\nID: %d\nProject: %d\nTitle: %s\nStatus: %s\nPriority: %s",
            $task->id,
            $task->project_id,
            $task->title,
            $task->status,
            $task->priority,
        );

        SendTelegramMessageJob::dispatch($text);
    }
}
