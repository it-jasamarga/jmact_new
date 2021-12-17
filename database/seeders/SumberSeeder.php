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
                'description' =>'Call Center 14080',
                'active' => 1
            ],
            [
                'code' => 'B',
                'description' =>'Travoy',
                'active' => 1
            ],
            [
                'code' => 'C',
                'description' =>'Twitter',
                'active' => 1
            ],
            [
                'code' => 'D',
                'description' =>'Instagram',
                'active' => 1
            ],
            [
                'code' => 'E',
                'description' =>'Facebook',
                'active' => 1
            ],
            [
                'code' => 'F',
                'description' =>'Youtube',
                'active' => 1
            ],
            [
                'code' => 'G',
                'description' =>'Media Cetak',
                'active' => 1
            ],
            [
                'code' => 'H',
                'description' =>'Laporan Petugas',
                'active' => 1
            ],
            [
                'code' => 'I',
                'description' =>'Whatsapp',
                'active' => 1
            ],
            [
                'code' => 'J',
                'description' =>'Lain Lain',
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterSumber::insert($array);
    }
}
