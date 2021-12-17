<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterGolken;
use Facades\Str;
use DB;
class GolonganKendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterGolken::truncate();

        $array = [
            [
                'golongan' => 'I',
                'description' => 'Sedan, Jip, Minibus, Bus, Pickup',
                'active' => 1
            ],
            [
                'golongan' => 'II',
                'description' => 'Truk dengan dua gandar',
                'active' => 1
            ],
            [
                'golongan' => 'III',
                'description' => 'Truk dengan tiga gandar',
                'active' => 1
            ],
            [
                'golongan' => 'IV',
                'description' => 'Truk dengan empat gandar',
                'active' => 1
            ],
            [
                'golongan' => 'V',
                'description' => 'Truk dengan lima gandar atau lebih',
                'active' => 1
            ],
            [
                'golongan' => 'VI',
                'description' => 'Sepeda motor',
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterGolken::insert($array);
    }
}
