<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@email.com')->first();
        $agendas = [
            [
                "name" => "Uji Sertifikasi Komputer",
                "dateTime" => "2025-10-22 08:00:00",
                "created_by" => $user->id,
                "updated_by" => $user->id,
            ],
            [
                "name" => "Tes Kemampuan Akademik (TKA)",
                "dateTime" => "2025-11-05 08:00:00",
                "created_by" => $user->id,
                "updated_by" => $user->id,
            ],
            [
                "name" => "Ujian Kompetensi Keahlian (UKK)",
                "dateTime" => "2026-01-21 08:00:00",
                "created_by" => $user->id,
                "updated_by" => $user->id,
            ]
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
}
