<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::firstOrCreate(['status' => 'Active']);
        Status::firstOrCreate(['status' => 'Inactive']);
    }
}
