<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class GenerateReport extends Command
{

    protected $signature = 'app:generate-report';

    protected $description = 'Generate a report with task count statistics for each project by status and save it in the database table or optionally as a JSON file.';

    public function handle()
    {
        $this->info('Start generate report..');

        $projects = Project::with('tasks')->get();

        if ($projects->isEmpty()) {
            $this->warn('No projects to proceed.');
            return Command::SUCCESS;
        }

        $payload = [];

        foreach ($projects as $project) {
            $statuses = [
                'todo' => 0,
                'in_progress' => 0,
                'done' => 0,
                'expired' => 0,
            ];

            foreach ($project->tasks as $task) {
                $status = $task->status;
                if (isset($statuses[$status])) {
                    $statuses[$status]++;
                }
            }

            $payload[] = [
                'project_id' => $project->id,
                'project_name' => $project->name,
                'statuses' => $statuses,
                'total_tasks' => $project->tasks->count(),
            ];
        }

        $report = Report::create([
            'period_start' => now()->startOfDay(),
            'period_end'   => now()->endOfDay(),
            'payload'      => json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            'path'         => null,
        ]);

        $path = 'reports/report_' . now()->format('Y_m_d_H_i_s') . '.json';
        Storage::put($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $report->update(['path' => $path]);

        $this->info('Report save in file: ' . $path);

        return Command::SUCCESS;
    }
}
