<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeedbackUnsatisfaction;

class FeedbackUnsatisfactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeedbackUnsatisfaction::truncate();

        $ketidakpuasan = [
            "Tarif derek tidak sesuai",
            "Sikap petugas kurang ramah",
            "Waktu tunggu terlalu lama (Lebih dari 30 menit)",
            "Penanganan kecelakaan kurang baik"
        ];

        $data = [];
        foreach ($ketidakpuasan as $item) {
            $data[] = [ 'ketidakpuasan' => $item];
        }

        FeedbackUnsatisfaction::insert($data);
    }
}
