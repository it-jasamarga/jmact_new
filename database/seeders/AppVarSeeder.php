<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppVar;

class AppVarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppVar::truncate();

        $data = [
            [ 'name' => "Chart Area Jasamarga Transjawa Tol", 'value' => "#C0D8C0" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol", 'value' => "#F5EEDC" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol", 'value' => "#DD4A48" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - Representative Office 1", 'value' => "#ECB390" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Jalanlayang Cikampek", 'value' => "#D77FA1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - Representative Office 2", 'value' => "#BAABDA" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Semarang Batang", 'value' => "#D6E5FA" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - Representative Office 2", 'value' => "#D3DEDC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Trans Marga Jateng", 'value' => "#92A9BD" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Solo Ngawi", 'value' => "#2FDD92" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Ngawi Kertosono", 'value' => "#B97A95" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Surabaya Mojokerto", 'value' => "#FEECE9" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - Representative Office 3", 'value' => "#CCD1E4" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Gempol Pasuruan", 'value' => "#FE7E6D" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Pandaan Tol", 'value' => "#2F3A8F" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Pandaan Malang", 'value' => "#876445" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - Representative Office 1", 'value' => "#CA965C" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Kualanamu Tol", 'value' => "#FC997C" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Bali Tol", 'value' => "#F4DFBA" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Balikpapan Samarinda", 'value' => "#D9D7F1" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Manado Bitung", 'value' => "#A3E4DB" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1", 'value' => "#E7FBBE" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 2", 'value' => "#FFCBCB" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 3", 'value' => "#FF5959" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Marga Lingkar Jakarta", 'value' => "#C1A3A3" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Jasamarga Kunciran Cengkareng", 'value' => "#886F6F" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Marga Trans Nusantara", 'value' => "#694E4E" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Cinere Serpong Jaya", 'value' => "#E60965" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Marga Sarana Jabar", 'value' => "#370665" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1 - JAGORAWI", 'value' => "#FFA1C9" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1 - JORR E", 'value' => "#FBE5E5" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1 - JORR W2S", 'value' => "#632626" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1 - PONDOK AREN-ULUJAMI", 'value' => "#9D5353" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1 - JAKARTA - CIKAMPEK", 'value' => "#BF8B67" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 1 - BELMERA", 'value' => "#DACC96" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 2 - JAKARTA - TANGERANG", 'value' => "#F3C5C5" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 2 - DALAM KOTA (CAWANG - TOMANG - PLUIT)", 'value' => "#C1A3A3" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 2 - PROF. DR.IR SOEDIJATMO", 'value' => "#886F6F" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 2 - PALIKANCI", 'value' => "#694E4E" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 2 - SEMARANG ABC", 'value' => "#FFE162" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 3 - CIPULARANG", 'value' => "#FF6464" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 3 - PADALEUNYI", 'value' => "#91C483" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - Representative Office 3 - SURABAYA - GEMPOL", 'value' => "#EEEEEE" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Marga Trans Nusantara - KUNCIRAN - SERPONG", 'value' => "#C0D8C0" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Marga Sarana Jabar - BORR", 'value' => "#F5EEDC" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Marga Lingkar Jakarta - JORR W2U (ULUJAMI – KEMBANGAN)", 'value' => "#DD4A48" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Jasamarga Kunciran Cengkareng - CENGKARENG-BATU CEPER-KUNCIRAN", 'value' => "#ECB390" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol - PT Cinere Serpong Jaya - SERPONG - PAMULANG", 'value' => "#FF6363" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Kualanamu Tol - MEDAN - KUALANAMU - TEBING TINGGI", 'value' => "#FFAB76" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Bali Tol - BALI - MANDARA", 'value' => "#FFFDA2" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Balikpapan Samarinda - BALIKPAPAN - SAMARINDA", 'value' => "#BAFFB4" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol - PT Jasamarga Manado Bitung - MANADO - BITUNG", 'value' => "#781C68" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Trans Marga Jateng - SEMARANG - SOLO", 'value' => "#9A0680" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Surabaya Mojokerto - MOJOKERTO - SURABAYA", 'value' => "#FFD39A" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Solo Ngawi - SOLO - NGAWI", 'value' => "#FFF5E1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Semarang Batang - BATANG - SEMARANG", 'value' => "#6867AC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Pandaan Tol - GEMPOL - PANDAAN", 'value' => "#A267AC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Pandaan Malang - PANDAAN - MALANG", 'value' => "#CE7BB0" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Ngawi Kertosono - NGAWI - KERTOSONO", 'value' => "#FFBCD1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Jalanlayang Cikampek - JALAN LAYANG MBZ", 'value' => "#D9D7F1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol - PT Jasamarga Gempol Pasuruan - GEMPOL - PASURUAN", 'value' => "#FFFDDE" ],            
            [ 'name' => "Chart Source Call Center 14080", 'value' => "#F0E9D2" ],
            [ 'name' => "Chart Source Travoy", 'value' => "#E6DDC4" ],
            [ 'name' => "Chart Source Twitter", 'value' => "#678983" ],
            [ 'name' => "Chart Source Instagram", 'value' => "#7EB5A6" ],
            [ 'name' => "Chart Source Facebook", 'value' => "#C36839" ],
            [ 'name' => "Chart Source Youtube", 'value' => "#86340A" ],
            [ 'name' => "Chart Source Media Cetak", 'value' => "#FF5959" ],
            [ 'name' => "Chart Source Laporan Petugas", 'value' => "#35589A" ],
            [ 'name' => "Chart Source Whatsapp", 'value' => "#FFFEA9" ],
            [ 'name' => "Chart Source Lain Lain", 'value' => "#" ],
            [ 'name' => "Chart Sector Iklan", 'value' => "#F3ED9E" ],
            [ 'name' => "Chart Sector Konstruksi", 'value' => "#FF5959" ],
            [ 'name' => "Chart Sector Lalin", 'value' => "#FAF0AF" ],
            [ 'name' => "Chart Sector Rest Area", 'value' => "#E5EDB7" ],
            [ 'name' => "Chart Sector Transaksi", 'value' => "#8BCDCD" ],
            [ 'name' => "Chart Sector Lain-lain", 'value' => "#ABC2E8" ],
            [ 'name' => "Chart Claim Type Rambu portal di gerbang tol", 'value' => "#DACC96" ],
            [ 'name' => "Chart Claim Type Sarana dan prasarana di gerbang tol", 'value' => "#F3C5C5" ],
            [ 'name' => "Chart Claim Type Kejatuhan ALB", 'value' => "#C1A3A3" ],
            [ 'name' => "Chart Claim Type Kelebihan pemotongan saldo", 'value' => "#886F6F" ],
            [ 'name' => "Chart Claim Type Kesalahan deteksi golongan", 'value' => "#694E4E" ],
            [ 'name' => "Chart Claim Type Pengaturan lalu lintas", 'value' => "#FFE162" ],
            [ 'name' => "Chart Claim Type Pentalan material", 'value' => "#FF6464" ],
            [ 'name' => "Chart Claim Type Rintangan di jalan tol (batu, balok, besi)", 'value' => "#91C483" ],
            [ 'name' => "Chart Claim Type Pelemparan Batu", 'value' => "#EEEEEE" ],
            [ 'name' => "Chart Claim Type Gangguan orang gila/hewan", 'value' => "#C0D8C0" ],
            [ 'name' => "Chart Claim Type Naik turun Penumpang", 'value' => "#F5EEDC" ],
            [ 'name' => "Chart Claim Type Lainnya yang termasuk lingkup pengoperasian jalan tol", 'value' => "#DD4A48" ],
            [ 'name' => "Chart Claim Type Lubang", 'value' => "#ECB390" ],
            [ 'name' => "Chart Claim Type Gundukan Aspal", 'value' => "#FF6363" ],
            [ 'name' => "Chart Claim Type Genangan Air", 'value' => "#FFAB76" ],
            [ 'name' => "Chart Claim Type Pohon tumbang", 'value' => "#FFFDA2" ],
            [ 'name' => "Chart Claim Type Kerusakan rambu di lajur", 'value' => "#BAFFB4" ],
            [ 'name' => "Chart Claim Type Kerusakan PJU", 'value' => "#781C68" ],
            [ 'name' => "Chart Claim Type Konstruksi jembatan", 'value' => "#9A0680" ],
            [ 'name' => "Chart Claim Type Kegiatan pemeliharaan", 'value' => "#FFD39A" ],
            [ 'name' => "Chart Claim Type Pagar/Rambu proyek", 'value' => "#FFF5E1" ],
            [ 'name' => "Chart Claim Type Sarkapja (guardrail, rambu, marka, dll.)", 'value' => "#6867AC" ],
            [ 'name' => "Chart Claim Type Lainnya yang termasuk lingkup pemeliharaan jalan tol", 'value' => "#A267AC" ],
            [ 'name' => "Chart Claim Type Konstruksi billboard/iklan", 'value' => "#CE7BB0" ],
            [ 'name' => "Chart Claim Type keluhan terkait rest area", 'value' => "#FFBCD1" ],
            [ 'name' => "Chart Claim Type Lubang di rest area", 'value' => "#D9D7F1" ],
            [ 'name' => "Chart Claim Type Genangan Air di rest area", 'value' => "#FFFDDE" ],
            [ 'name' => "Chart Claim Type Lainnya yang termasuk lingkup pengelolaan rest area", 'value' => "#FFA1C9" ]
        ];

        AppVar::insert($data);
    }
}
