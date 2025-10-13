<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = Status::where('status', 'Active')->first();
        $forums = [
            [
                "forum_name" => "SPMB",
                "description" => "Kapan Pendaftarannya Dibuka?",
                "status_id" => $status->id
            ],
            [
                "forum_name" => "Libur Semester",
                "description" => "Kapan Libur Semester Resmi Dimulai?",
                "status_id" => $status->id
            ],
            [
                "forum_name" => "Pengalaman Kuliah Setelah Lulus",
                "description" => "Cerita pengalaman kuliah",
                "status_id" => $status->id
            ],
        ];

        foreach ($forums as $forum) {
            Forum::create($forum);
        }
    }
}
