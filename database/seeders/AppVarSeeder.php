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
            [ 'name' => "Chart Area Jasamarga Transjawa Tol Representative Office 1", 'value' => "#ECB390" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Jalanlayang Cikampek", 'value' => "#D77FA1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol Representative Office 2", 'value' => "#BAABDA" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Semarang Batang", 'value' => "#D6E5FA" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol Representative Office 2", 'value' => "#D3DEDC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Trans Marga Jateng", 'value' => "#92A9BD" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Solo Ngawi", 'value' => "#7C99AC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Ngawi Kertosono", 'value' => "#FFEFEF" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Surabaya Mojokerto", 'value' => "#FEECE9" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol Representative Office 3", 'value' => "#CCD1E4" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Gempol Pasuruan", 'value' => "#FE7E6D" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Pandaan Tol", 'value' => "#2F3A8F" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Pandaan Malang", 'value' => "#876445" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol Representative Office 1", 'value' => "#CA965C" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Kualanamu Tol", 'value' => "#EEC373" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Bali Tol", 'value' => "#F4DFBA" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Balikpapan Samarinda", 'value' => "#D9D7F1" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Manado Bitung", 'value' => "#FFFDDE" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1", 'value' => "#E7FBBE" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 2", 'value' => "#FFCBCB" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 3", 'value' => "#F3C5C5" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Marga Lingkar Jakarta", 'value' => "#C1A3A3" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Jasamarga Kunciran Cengkareng", 'value' => "#886F6F" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Marga Trans Nusantara", 'value' => "#694E4E" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Cinere Serpong Jaya", 'value' => "#E60965" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Marga Sarana Jabar", 'value' => "#F94892" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1 JAGORAWI", 'value' => "#FFA1C9" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1 JORR E", 'value' => "#FBE5E5" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1 JORR W2S", 'value' => "#632626" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1 PONDOK AREN-ULUJAMI", 'value' => "#9D5353" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1 JAKARTA - CIKAMPEK", 'value' => "#BF8B67" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 1 BELMERA", 'value' => "#DACC96" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 2 JAKARTA - TANGERANG", 'value' => "#F3C5C5" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 2 DALAM KOTA (CAWANG - TOMANG - PLUIT)", 'value' => "#C1A3A3" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 2 PROF. DR.IR SOEDIJATMO", 'value' => "#886F6F" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 2 PALIKANCI", 'value' => "#694E4E" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 2 SEMARANG ABC", 'value' => "#FFE162" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 3 CIPULARANG", 'value' => "#FF6464" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 3 PADALEUNYI", 'value' => "#91C483" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol Representative Office 3 SURABAYA - GEMPOL", 'value' => "#EEEEEE" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Marga Trans Nusantara KUNCIRAN - SERPONG", 'value' => "#C0D8C0" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Marga Sarana Jabar BORR", 'value' => "#F5EEDC" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Marga Lingkar Jakarta JORR W2U (ULUJAMI – KEMBANGAN)", 'value' => "#DD4A48" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Jasamarga Kunciran Cengkareng CENGKARENG-BATU CEPER-KUNCIRAN", 'value' => "#ECB390" ],
            [ 'name' => "Chart Area Jasamarga Metropolitan Tol PT Cinere Serpong Jaya SERPONG - PAMULANG", 'value' => "#FF6363" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Kualanamu Tol MEDAN - KUALANAMU - TEBING TINGGI", 'value' => "#FFAB76" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Bali Tol BALI - MANDARA", 'value' => "#FFFDA2" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Balikpapan Samarinda BALIKPAPAN - SAMARINDA", 'value' => "#BAFFB4" ],
            [ 'name' => "Chart Area Jasamarga Nusantara Tol PT Jasamarga Manado Bitung MANADO - BITUNG", 'value' => "#781C68" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Trans Marga Jateng SEMARANG - SOLO", 'value' => "#9A0680" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Surabaya Mojokerto MOJOKERTO - SURABAYA", 'value' => "#FFD39A" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Solo Ngawi SOLO - NGAWI", 'value' => "#FFF5E1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Semarang Batang BATANG - SEMARANG", 'value' => "#6867AC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Pandaan Tol GEMPOL - PANDAAN", 'value' => "#A267AC" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Pandaan Malang PANDAAN - MALANG", 'value' => "#CE7BB0" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Ngawi Kertosono NGAWI - KERTOSONO", 'value' => "#FFBCD1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Jalanlayang Cikampek JALAN LAYANG MBZ", 'value' => "#D9D7F1" ],
            [ 'name' => "Chart Area Jasamarga Transjawa Tol PT Jasamarga Gempol Pasuruan GEMPOL - PASURUAN", 'value' => "#FFFDDE" ]            
        ];

        AppVar::insert($data);
    }
}
