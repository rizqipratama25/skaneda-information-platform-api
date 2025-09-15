<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    public function run(): void
    {
        UserStatus::firstOrCreate(['name' => 'admin']);
        UserStatus::firstOrCreate(['name' => 'user']);
    }
}
