<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AgendaSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(JobListingSeeder::class);
        $this->call(ForumsSeeder::class);
        $this->call(ChatsSeeder::class);
        $this->call(FacilitiesSeeder::class);
        $this->call(AchievementCategoriesSeeder::class);
        $this->call(PartnerSeeder::class);
    }
}
