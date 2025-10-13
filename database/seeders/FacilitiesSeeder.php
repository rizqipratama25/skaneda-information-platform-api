<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $active = Status::firstOrCreate(['status' => 'Active']);
        $inactive = Status::firstOrCreate(['status' => 'Inactive']);

        $facilities = [
            [
                "name" => "LAB RPL",
                "status_id" => $active->id
            ],
            [
                "name" => "LAB DKV",
                "status_id" => $active->id
            ],
            [
                "name" => "LAB TB",
                "status_id" => $inactive->id
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
