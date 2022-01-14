<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Facades\Str;
use App\Models\MasterStatus;
use DB;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterStatus::truncate();
        $array = [
            [
                'code' => '01',
                'status' =>'Tiket di Input',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '01',
                'status' =>'Tiket di Input',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '02',
                'status' =>'Tiket diteruskan',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '02',
                'status' =>'Tiket di approve',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '03',
                'status' =>'Tiket diterima',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '03',
                'status' =>'Tiket diteruskan',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '04',
                'status' =>'On Progress',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '04',
                'status' =>'Tahap Klarifikasi dan Negosiasi',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '05',
                'status' =>'Closed',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '05',
                'status' =>'Proses Pembayaran',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '06',
                'status' =>'Overtime',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '06',
                'status' =>'Closed',
                'type' => 2,
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterStatus::insert($array);
    }
}
