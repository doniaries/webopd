<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\Category;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Get all teams
        $teams = Team::all();

        if ($teams->isEmpty()) {
            $this->command->warn('No teams found. Please run TeamSeeder first!');
            return;
        }

        // Get categories from enum
        $categories = CategoryType::toArray();

        // Create categories for each team
        foreach ($teams as $team) {
            foreach ($categories as $category) {
                // Check if category already exists for this team
                if (!Category::where('team_id', $team->id)
                    ->where('name', $category['name'])
                    ->exists()) {
                    
                    // Create category with team_id
                    Category::create([
                        'team_id' => $team->id,
                        'name' => $category['name'],
                        'slug' => Str::slug($category['name']),
                        'is_active' => $category['is_active'],
                    ]);
                }
            }
        }
    }
}
