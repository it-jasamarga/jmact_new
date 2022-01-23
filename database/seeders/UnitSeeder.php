<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Facades\Str;
use App\Models\MasterUnit;
use DB;
class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterUnit::truncate();
        $array = [
            [
                'code' => '01',
                'unit' =>'JMTC',
                'active' => 1,
                'type' => null
            ],
            [
                'code' => '02',
                'unit' =>'CCO',
                'active' => 1,
                'type' => null
            ],
            [
                'code' => '03',
                'unit' =>'MARCOM',
                'active' => 1,
                'type' => null
            ],
            [
                'code' => '04',
                'unit' =>'JMTM',
                'active' => 1,
                'type' => 1
            ],
            [
                'code' => '05',
                'unit' =>'JMRB',
                'active' => 1,
                'type' => 1
            ],
            [
                'code' => '06',
                'unit' =>'JMTO',
                'active' => 1,
                'type' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterUnit::insert($array);
    }
}
