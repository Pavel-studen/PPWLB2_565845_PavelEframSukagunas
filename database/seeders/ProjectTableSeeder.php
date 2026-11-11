<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\Project::create([
                'title' => 'Project ' . $i,
                'description' => 'Description for Project ' . $i,
                'category_id' => rand(1, 5), // Assuming you have 5 categories
                'technology_id' => rand(1, 5), // Assuming you have 5 technologies
                'skill_id' => rand(1, 5), // Assuming you have 5 skills
            ]);
        }
    }
}
