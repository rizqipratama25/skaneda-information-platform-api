<?php

namespace Database\Seeders;

use App\Models\AchievementCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Akademik'
            ],
            [
                'name' => 'Non Akademik'
            ],
        ];

        foreach ($categories as $category) {
            AchievementCategories::create($category);
        }
    }
}
