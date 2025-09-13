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
                "name" => "admin",
                "email" => "admin@email.com",
                "password" => Hash::make('123')
            ],
            [
                "name" => "creator",
                "email" => "creator@email.com",
                "password" => Hash::make('123')
            ],
            [
                "name" => "editor",
                "email" => "editor@email.com",
                "password" => Hash::make('123')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
