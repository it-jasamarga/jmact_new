<?php

namespace Database\Seeders;

use App\Models\MasterJenisClaim;
use Illuminate\Database\Seeder;

use Facades\Str;
use DB;

class JenisClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterJenisClaim::truncate();

        $array = [
            [
                'code' => '01',
                'jenis_claim' => 'Genangan Air',
                'active' => 1
            ],
            [
                'code' => '02',
                'jenis_claim' => 'Gundukan Aspal',
                'active' => 1
            ],
            [
                'code' => '03',
                'jenis_claim' => 'Lubang',
                'active' => 1
            ],
            [
                'code' => '04',
                'jenis_claim' => 'Material',
                'active' => 1
            ],
            [
                'code' => '05',
                'jenis_claim' => 'Pelemparan Batu',
                'active' => 1
            ],
            [
                'code' => '06',
                'jenis_claim' => 'Pentalan Material',
                'active' => 1
            ],
            [
                'code' => '07',
                'jenis_claim' => 'Pohon Tumbang',
                'active' => 1
            ],
            [
                'code' => '08',
                'jenis_claim' => 'Rambu Proyek',
                'active' => 1
            ],
            [
                'code' => '09',
                'jenis_claim' => 'Salah Golongan',
                'active' => 1
            ],
            [
                'code' => '9999',
                'jenis_claim' => 'Lain-lain',
                'active' => 1
            ]
        ];
        MasterJenisClaim::insert($array);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
