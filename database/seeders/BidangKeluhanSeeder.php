<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MasterBk;

use Facades\Str;
use DB;

class BidangKeluhanSeeder extends Seeder
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
        MasterBk::truncate();

        $array = [
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Lubang',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Rambu',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Uang Kembalian',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Banjir',
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Kondisi Obyek',
                'active' => 1
            ]
        ];
        MasterBk::insert($array);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}