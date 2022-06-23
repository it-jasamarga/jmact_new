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
                'status' =>'Tiket diinput',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '02',
                'status' =>'Tiket diteruskan',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '03',
                'status' =>'On Progress',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '04',
                'status' =>'Submit Report',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '05',
                'status' =>'Konfirmasi Pelanggan',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '06',
                'status' =>'Follow Up Feedback Pelanggan',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '07',
                'status' =>'Closed',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '08',
                'status' =>'Overtime',
                'type' => 1,
                'active' => 1
            ],
            [
                'code' => '01',
                'status' =>'Tiket diinput',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '02',
                'status' =>'Approved',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '03',
                'status' =>'Rejected',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '04',
                'status' =>'Tiket diteruskan',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '05',
                'status' =>'Monitoring RO(Proyek)',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '06',
                'status' =>'Negosiasi & Klarifikasi',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '07',
                'status' =>'Proses Pembayaran',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '08',
                'status' =>'Pembayaran Selesai',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '09',
                'status' =>'Follow Up Feedback Pelanggan',
                'type' => 2,
                'active' => 1
            ],
            [
                'code' => '10',
                'status' =>'Closed',
                'type' => 2,
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterStatus::insert($array);
    }
}
