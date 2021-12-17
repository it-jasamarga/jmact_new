<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterRo;
use App\Models\MasterRegional;
use Facades\Str;
use DB;

class RoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MasterRo::truncate();

        $array = [
            [
                'name' => 'Representative Office 1',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 2',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 3',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Marga Lingkar Jakarta',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Kunciran Cengkareng',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Marga Trans Nusantara',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Cinere Serpong Jaya',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Marga Sarana Jabar',
                'regional_id' => 'Jasamarga Metropolitan Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 1',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Jalanlayang Cikampek',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 2',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Semarang Batang',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 2',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Trans Marga Jateng',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Solo Ngawi',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Ngawi Kertosono',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Surabaya Mojokerto',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 3',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Gempol Pasuruan',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Pandaan Tol',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Pandaan Malang',
                'regional_id' => 'Jasamarga Transjawa Tol',
                'active' => 1,
            ],
            [
                'name' => 'Representative Office 1',
                'regional_id' => 'Jamamarga Nusantara Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Kualanamu Tol',
                'regional_id' => 'Jamamarga Nusantara Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Bali Tol',
                'regional_id' => 'Jamamarga Nusantara Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Balikpapan Samarinda',
                'regional_id' => 'Jamamarga Nusantara Tol',
                'active' => 1,
            ],
            [
                'name' => 'PT Jasamarga Manado Bitung',
                'regional_id' => 'Jamamarga Nusantara Tol',
                'active' => 1,
            ]
        ];

        foreach($array as $k => $value){
            
            $record = MasterRegional::where('name',$value['regional_id'])->first();
            if($record){
                $value['regional_id'] = $record->id;
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            
            MasterRo::create($value);
        }

    }
}
