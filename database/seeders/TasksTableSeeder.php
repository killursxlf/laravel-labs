<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TasksTableSeeder extends Seeder
{
    public function run(): void
    {
        Task::truncate();

        $tasks = [
            ['project_id' => 1, 'author_id' => 1, 'assignee_id' => 2, 'title' => 'Create migrations', 'description' => 'Implement database structure for all entities.', 'status' => 'done', 'priority' => 'high'],
            ['project_id' => 1, 'author_id' => 2, 'assignee_id' => 1, 'title' => 'Add seeders', 'description' => 'Fill tables with test data.', 'status' => 'in_progress', 'priority' => 'medium'],
            ['project_id' => 2, 'author_id' => 3, 'assignee_id' => 4, 'title' => 'Develop UI components', 'description' => 'Build main React components for frontend.', 'status' => 'open', 'priority' => 'normal'],
            ['project_id' => 3, 'author_id' => 1, 'assignee_id' => 5, 'title' => 'Integrate API', 'description' => 'Connect external REST API to the system.', 'status' => 'open', 'priority' => 'high'],
            ['project_id' => 4, 'author_id' => 2, 'assignee_id' => 3, 'title' => 'Homepage redesign', 'description' => 'Create a new layout for the landing page.', 'status' => 'done', 'priority' => 'low'],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
