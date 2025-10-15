<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                "name" => "PT. Universal Big Data"
            ],
            [
                "name" => "PT. Otak Kanan"
            ],
            [
                "name" => "Minarsih Tech"
            ],
            [
                "name" => "PT. KOffiesoft"
            ],
            [
                "name" => "PT. Humma Teknologi Indonesia"
            ],
            [
                "name" => "Top Sell"
            ]
        ];

        foreach($partners as $partner) {
            Partner::create($partner);
        }
    }
}
