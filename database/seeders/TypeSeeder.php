<?php

namespace Database\Seeders;

use App\Models\MasterType;
use Illuminate\Database\Seeder;
use DB;

class TypeSeeder extends Seeder
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
        MasterType::truncate();
        $array = [
            [
                'type' => 'Admin',
                'active' => 1
            ],
            [
                'type' => 'Inputer',
                'active' => 1
            ],
            [
                'type' => 'Supervisor JMTC',
                'active' => 1
            ],
            [
                'type' => 'Service Provider',
                'active' => 1
            ],
            [
                'type' => 'JMTO Area',
                'active' => 1
            ],
            [
                'type' => 'Manager Area',
                'active' => 1
            ],
            [
                'type' => 'Representative Office',
                'active' => 1
            ],
            [
                'type' => 'Regional',
                'active' => 1
            ],
            [
                'type' => 'JM Pusat',
                'active' => 1
            ],
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterType::insert($array);
    }
}
