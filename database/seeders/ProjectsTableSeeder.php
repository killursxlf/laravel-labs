<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsTableSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate();

        $projects = [
            ['owner_id' => 1, 'name' => 'Vocab-forge Backend'],
            ['owner_id' => 2, 'name' => 'Vocab-forge Frontend'],
            ['owner_id' => 3, 'name' => 'CRM Integration'],
            ['owner_id' => 4, 'name' => 'Website Redesign'],
            ['owner_id' => 5, 'name' => 'Mobile Application'],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
