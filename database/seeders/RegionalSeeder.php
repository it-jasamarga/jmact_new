<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterRegional;
use Facades\Str;
use DB;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterRegional::truncate();

        $array = [
            [
                'name' => 'Jasamarga Transjawa Tol',
                'active' => 1
            ],
            [
                'name' => 'Jasamarga Nusantara Tol',
                'active' => 1
            ],
            [
                'name' => 'Jasamarga Metropolitan Tol',
                'active' => 1
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        MasterRegional::insert($array);
    }
}
