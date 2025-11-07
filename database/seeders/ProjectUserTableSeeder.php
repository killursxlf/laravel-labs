<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProjectUserTableSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        foreach ($projects as $project) {
            $users = User::where('id', '!=', $project->owner_id)
                         ->inRandomOrder()
                         ->take(2)
                         ->pluck('id');
            
            foreach ($users as $userId) {
                DB::table('project_user')->insert([
                    'project_id' => $project->id,
                    'user_id'    => $userId,
                    'role'       => 'member',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            DB::table('project_user')->insert([
                'project_id' => $project->id,
                'user_id'    => $project->owner_id,
                'role'       => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
