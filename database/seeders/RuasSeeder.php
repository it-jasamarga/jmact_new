<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterRuas;
use App\Models\MasterRo;
use Facades\Str;
use DB;

class RuasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterRuas::truncate();

        $array = [
            [
                'name' => 'JAGORAWI',
                'ro_id' => 'Representative Office 1',
                'active' => 1,
            ],
            [
                'name' => 'JORR E',
                'ro_id' => 'Representative Office 1',
                'active' => 1,
            ],
            [
                'name' => 'JORR W2S',
                'ro_id' => 'Representative Office 1',
                'active' => 1,
            ],
            [
                'name' => 'PONDOK AREN-ULUJAMI',
                'ro_id' => 'Representative Office 1',
                'active' => 1,
            ],
            [
                'name' => 'JAKARTA - TANGERANG',
                'ro_id' => 'Representative Office 2',
                'active' => 1,
            ],
            [
                'name' => 'DALAM KOTA (CAWANG - TOMANG - PLUIT)',
                'ro_id' => 'Representative Office 2',
                'active' => 1,
            ],
            [
                'name' => 'PROF. DR.IR SOEDIJATMO',
                'ro_id' => 'Representative Office 2',
                'active' => 1,
            ],
            [
                'name' => 'CIPULARANG',
                'ro_id' => 'Representative Office 3',
                'active' => 1,
            ],
            [
                'name' => 'PADALEUNYI',
                'ro_id' => 'Representative Office 3',
                'active' => 1,
            ],
            [
                'name' => 'JORR W2U (ULUJAMI – KEMBANGAN)',
                'ro_id' => 'PT Marga Lingkar Jakarta',
                'active' => 1,
            ],
            [
                'name' => 'CENGKARENG-BATU CEPER-KUNCIRAN',
                'ro_id' => 'PT Jasamarga Kunciran Cengkareng',
                'active' => 1,
            ],
            [
                'name' => 'KUNCIRAN - SERPONG',
                'ro_id' => 'PT Marga Trans Nusantara',
                'active' => 1,
            ],
            [
                'name' => 'SERPONG - PAMULANG',
                'ro_id' => 'PT Cinere Serpong Jaya',
                'active' => 1,
            ],
            [
                'name' => 'BORR',
                'ro_id' => 'PT Marga Sarana Jabar',
                'active' => 1,
            ],
            [
                'name' => 'JAKARTA - CIKAMPEK',
                'ro_id' => 'Representative Office 1',
                'active' => 1,
            ],
            [
                'name' => 'JALAN LAYANG MBZ',
                'ro_id' => 'PT Jasamarga Jalanlayang Cikampek',
                'active' => 1,
            ],
            [
                'name' => 'PALIKANCI',
                'ro_id' => 'Representative Office 2',
                'active' => 1,
            ],
            [
                'name' => 'BATANG - SEMARANG',
                'ro_id' => 'PT Jasamarga Semarang Batang',
                'active' => 1,
            ],
            [
                'name' => 'SEMARANG ABC',
                'ro_id' => 'Representative Office 2',
                'active' => 1,
            ],
            [
                'name' => 'SEMARANG - SOLO',
                'ro_id' => 'PT Trans Marga Jateng',
                'active' => 1,
            ],
            [
                'name' => 'SOLO - NGAWI',
                'ro_id' => 'PT Jasamarga Solo Ngawi',
                'active' => 1,
            ],
            [
                'name' => 'NGAWI - KERTOSONO',
                'ro_id' => 'PT Jasamarga Ngawi Kertosono',
                'active' => 1,
            ],
            [
                'name' => 'MOJOKERTO - SURABAYA',
                'ro_id' => 'PT Jasamarga Surabaya Mojokerto',
                'active' => 1,
            ],
            [
                'name' => 'SURABAYA - GEMPOL',
                'ro_id' => 'Representative Office 3',
                'active' => 1,
            ],
            [
                'name' => 'GEMPOL - PASURUAN',
                'ro_id' => 'PT Jasamarga Gempol Pasuruan',
                'active' => 1,
            ],
            [
                'name' => 'GEMPOL - PANDAAN',
                'ro_id' => 'PT Jasamarga Pandaan Tol',
                'active' => 1,
            ],
            [
                'name' => 'PANDAAN - MALANG',
                'ro_id' => 'PT Jasamarga Pandaan Malang',
                'active' => 1,
            ],
            [
                'name' => 'BELMERA',
                'ro_id' => 'Representative Office 1',
                'active' => 1,
            ],
            [
                'name' => 'MEDAN - KUALANAMU - TEBING TINGGI',
                'ro_id' => 'PT Jasamarga Kualanamu Tol',
                'active' => 1,
            ],
            [
                'name' => 'BALI - MANDARA',
                'ro_id' => 'PT Jasamarga Bali Tol',
                'active' => 1,
            ],
            [
                'name' => 'BALIKPAPAN - SAMARINDA',
                'ro_id' => 'PT Jasamarga Balikpapan Samarinda',
                'active' => 1,
            ],
            [
                'name' => 'MANADO - BITUNG',
                'ro_id' => 'PT Jasamarga Manado Bitung',
                'active' => 1,
            ]
        ];

        foreach($array as $k => $value){
            $record = MasterRo::where('name',$value['ro_id'])->first();

            if($record){
                $value['ro_id'] = $record->id;
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            MasterRuas::create($value);
        }

    }
}
