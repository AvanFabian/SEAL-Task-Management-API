<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $projects = [
            [
                'name' => 'E-commerce Website Redesign',
                'description' => 'Redesigning the company e-commerce website with modern UI/UX',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Developing a new mobile app for inventory management',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Database Migration',
                'description' => 'Migrating legacy database to new cloud infrastructure',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing Campaign',
                'description' => 'Q1 2024 Digital Marketing Campaign',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer Support Portal',
                'description' => 'Building new customer support portal with ticketing system',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        Project::insert($projects);
    }
}