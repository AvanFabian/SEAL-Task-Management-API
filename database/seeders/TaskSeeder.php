<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();
        $statuses = ['todo', 'in_progress', 'completed'];

        $tasks = [
            [
                'title' => 'Requirements Gathering',
                'description' => 'Collect and document project requirements',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Database Design',
                'description' => 'Design database schema and relationships',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'UI/UX Design',
                'description' => 'Create wireframes and mockups',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Frontend Development',
                'description' => 'Implement user interface components',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Backend Development',
                'description' => 'Implement server-side logic and APIs',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Testing',
                'description' => 'Perform unit and integration testing',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Documentation',
                'description' => 'Write technical and user documentation',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Deployment',
                'description' => 'Deploy application to production',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'User Training',
                'description' => 'Conduct training sessions for end users',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Maintenance',
                'description' => 'Regular system maintenance and updates',
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30)),
                'project_id' => $projects->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Task::insert($tasks);
    }
}