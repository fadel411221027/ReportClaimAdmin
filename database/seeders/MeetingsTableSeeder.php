<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meeting;
use App\Models\MeetingTopic;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MeetingsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Generate 10 random meetings
        for ($i = 0; $i < 10; $i++) {
            $meetingDate = $faker->dateTimeBetween('now', '+4 weeks')->setTime(9, 0);

            $meeting = Meeting::create([
                'meeting_date' => $meetingDate,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Topik-topik yang mungkin dibahas
            $topikRapat = [
                'Evaluasi Kinerja Tim',
                'Perencanaan Proyek Baru',
                'Laporan Perkembangan Bulanan',
                'Strategi Pengembangan Produk',
                'Diskusi Teknis Aplikasi',
                'Review Sprint Mingguan',
                'Koordinasi Antar Divisi',
                'Pelatihan Tim',
                'Analisis Performa Sistem',
                'Rencana Implementasi Fitur',
                'Evaluasi Feedback Pengguna',
                'Optimisasi Database',
                'Pembahasan Bug Report',
                'Pengembangan API',
                'Integrasi Sistem Baru'
            ];

            // Generate 2-5 topik per rapat
            $jumlahTopik = $faker->numberBetween(5, 11);

            for ($j = 0; $j < $jumlahTopik; $j++) {
                $meeting->topics()->create([
                    'title' => $faker->randomElement($topikRapat),
                    'description' => 'Pembahasan mengenai ' . $faker->sentence(8),
                    'is_completed' => $faker->boolean(30),
                    'user_id' => $faker->numberBetween(1, 13)
                ]);
            }
        }
    }
}
