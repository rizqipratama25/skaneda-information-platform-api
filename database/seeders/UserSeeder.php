<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "fullname" => "admin",
                "username" => "Kang admin",
                "email" => "admin@email.com",
                "role_id" => 1,
                "status_id" => 2,
                "password" => Hash::make('123')
            ],
            [
                "fullname" => "creator",
                "username" => "Kang Creator",
                "email" => "creator@email.com",
                "role_id" => 2,
                "status_id" => 1,
                "password" => Hash::make('123')
            ],
            [
                "fullname" => "editor",
                "username" => "Kang Editor",
                "email" => "editor@email.com",
                "role_id" => 2,
                "status_id" => 1,
                "password" => Hash::make('123')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
