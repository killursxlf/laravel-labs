<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class CheckOverdueTasks extends Command
{
    protected $signature = 'app:check-overdue-tasks';
    protected $description = 'Mark long in_progress tasks as expired and send Telegram notification';

    public function __construct(
        private readonly TelegramService $telegram,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Checking overdue tasks...');

        $overdueTasks = Task::query()
            ->where('status', 'in_progress')
            ->where('due_date', '<=', now()->subDays(7))
            ->get();

        if ($overdueTasks->isEmpty()) {
            $this->info('No overdue tasks found.');
            return self::SUCCESS;
        }

        foreach ($overdueTasks as $task) {
            $task->status = 'expired';
            $task->save();

            $text = sprintf(
                "Task #%d \"%s\" has been overdue for more than 7 days and has been set to status <b>expired</b>.\nProject: %s\nAssignee: %s",
                $task->id,
                $task->title,
                optional($task->project)->name ?? '-',
                optional($task->assignee)->name ?? '-'
            );

            $this->telegram->sendMessage($text);
        }

        $this->info("Processed {$overdueTasks->count()} overdue task(s).");

        return self::SUCCESS;
    }
}
