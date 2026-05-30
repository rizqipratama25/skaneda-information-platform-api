<?php

namespace Database\Seeders;

use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobType::firstOrCreate(['type' => 'Full Time']);
        JobType::firstOrCreate(['type' => 'Part Time']);
        JobType::firstOrCreate(['type' => 'Internship']);
    }
}
