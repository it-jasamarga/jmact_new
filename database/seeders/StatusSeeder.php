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
                'status' =>'Proses',
                'active' => 1
            ],
            [
                'code' => '02',
                'status' =>'Terima',
                'active' => 1
            ],
            [
                'code' => '03',
                'status' =>'Teruskan',
                'active' => 1
            ],
            [
                'code' => '04',
                'status' =>'Tutup',
                'active' => 1
            ],
            [
                'code' => '05',
                'status' =>'Proses SLA',
                'active' => 1
            ],
            [
                'code' => '06',
                'status' =>'Report SLA Submited',
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterStatus::insert($array);
    }
}
