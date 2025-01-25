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
            ],
            [
                'name' => 'API Integration',
                'description' => 'Integrating third-party payment gateway APIs',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Security Audit',
                'description' => 'Conducting comprehensive security audit of systems',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Content Management System',
                'description' => 'Developing new CMS for content team',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Employee Training Program',
                'description' => 'Creating online training modules for new employees',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Data Analytics Dashboard',
                'description' => 'Building real-time analytics dashboard',
                'user_id' => $users->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Project::insert($projects);
    }
}
