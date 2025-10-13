<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Forum;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $forum = Forum::firstOrCreate(["forum_name" => "SPMB"]);
        
        $admin = User::where('email', 'admin@email.com')->first();
        $user = User::where('email', 'creator@email.com')->first();

        $active = Status::firstOrCreate(['status' => 'Active']);
        $pending = Status::firstOrCreate(['status' => 'Pending']);

        $chats = [
            [
                "chat" => "Apakah ada persyaratan khusus untuk berkas yang perlu dibawa? Saya sudah menyiapkan fotokopi rapor dan kartu keluarga.",
                "user_id" => $user->id,
                "forum_id" => $forum->id,
                'status_id' => $active->id
            ],
            [
                "chat" => "Berikut persyaratan berkas PPDB yang harus dibawa:\n1. Fotokopi rapor semester 1-5 yang dilegalisir\n2. Fotokopi kartu keluarga\n3. Fotokopi akta kelahiran\n4. Pas foto berwarna ukuran 3x4 (4 lembar)\n5. Surat keterangan sehat dari dokter\nSemua berkas dimasukkan dalam map berwarna biru untuk laki-laki dan merah untuk perempuan.",
                "user_id" => $admin->id,
                "forum_id" => $forum->id,
                'status_id' => $active->id
            ],
            [
                "chat" => "Terima kasih atas informasinya. Untuk surat keterangan sehat, apakah ada format khusus atau cukup surat keterangan biasa dari dokter?",
                "user_id" => $user->id,
                "forum_id" => $forum->id,
                'status_id' => $pending->id
            ],
        ];

        foreach ($chats as $chat) {
            Chat::create($chat);
        }
    }
}
