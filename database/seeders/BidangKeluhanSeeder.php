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
                'bidang' => 'Lubang',
                'keluhan' => 'Konstruksi',
                'active' => 1
            ],
            [
                'bidang' => 'Rambu',
                'keluhan' => 'Lalin',
                'active' => 1
            ],
            [
                'bidang' => 'Uang Kembalian',
                'keluhan' => 'Transaksi',
                'active' => 1
            ],
            [
                'bidang' => 'Banjir',
                'keluhan' => 'Konstruksi',
                'active' => 1
            ],
            [
                'bidang' => 'Kondisi Obyek',
                'keluhan' => 'Iklan',
                'active' => 1
            ]
        ];
        MasterBk::insert($array);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}