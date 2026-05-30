<?php

namespace Database\Seeders;

use App\Models\JobListing;
use App\Models\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $full = JobType::where('type', 'Full Time')->first();
        $part = JobType::where('type', 'Part Time')->first();
        $intern = JobType::where('type', 'Part Time')->first();

        $jobs = [
            [
                "name" => "Bilco Handmade",
                "open_positions" => 4,
                "position" => "Staff Produksi",
                "description" => "asndjasndjns",
                "type_id" => $full->id,
                "location" => "Mojokerto",
                "registration_link" => "www.google.com"
            ],
            [
                "name" => "Dea Bakery",
                "open_positions" => 4,
                "position" => "Operator Packing",
                "description" => "asndjasndjns",
                "type_id" => $part->id,
                "location" => "Surabaya",
                "registration_link" => "www.google.com"
            ],
            [
                "name" => "BeMySkin",
                "open_positions" => 4,
                "position" => "Crew Store",
                "description" => "asndjasndjns",
                "type_id" => $intern->id,
                "location" => "Mojokerto",
                "registration_link" => "www.google.com"
            ],
        ];

        foreach ($jobs as $job) {
            JobListing::create($job);
        }
    }
}
