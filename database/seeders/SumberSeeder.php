<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Facades\Str;
use App\Models\MasterSumber;
use DB;
class SumberSeeder extends Seeder
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
        MasterSumber::truncate();
        $array = [
            [
                'code' => 'A',
                'description' => 'Call Center 14080',
                'keluhan' => true,
                'claim' => true,
                'active' => 1
            ],
            [
                'code' => 'B',
                'description' =>'Travoy',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'C',
                'description' => 'Twitter',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'D',
                'description' => 'Instagram',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'E',
                'description' => 'Facebook',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'F',
                'description' => 'Youtube',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'G',
                'description' => 'Media Cetak',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'H',
                'description' => 'Laporan Petugas',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'I',
                'description' => 'Whatsapp',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'J',
                'description' => 'Lain Lain',
                'keluhan' => true,
                'claim' => false,
                'active' => 1
            ],
            [
                'code' => 'K',
                'description' => 'JMTO Area',
                'keluhan' => true,
                'claim' => true,
                'active' => 1
            ],
            [
                'code' => 'L',
                'description' => 'JMTM Area',
                'keluhan' => true,
                'claim' => true,
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterSumber::insert($array);
    }
}
