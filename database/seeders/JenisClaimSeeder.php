<?php

namespace Database\Seeders;

use App\Models\MasterJenisClaim;
use App\Models\MasterUnit;
use Illuminate\Database\Seeder;

use Facades\Str;
use DB;

class JenisClaimSeeder extends Seeder
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
        MasterJenisClaim::truncate();

        $array = [
            [
                'code' => '01',
                'jenis_claim' => 'Kerusakan sarana dan prasarana di gerbang tol (kejatuhan rambu portal, dll.)',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '02',
                'jenis_claim' => 'Malfungsi Lattol (kejatuhan ALB, kelebihan pemotongan saldo, kesalahan deteksi golongan)',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '03',
                'jenis_claim' => 'Pengaturan lalu lintas',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '04',
                'jenis_claim' => 'Rintangan di jalan tol (batu, balok, besi)',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '05',
                'jenis_claim' => 'Gangguan dari orang gila / hewan',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '06',
                'jenis_claim' => 'Masalah kamtib (pelemparan batu, naik turun penumpang)',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '07',
                'jenis_claim' => 'Kerusakan permukaan jalan (lubang, gundukan aspal, genangan, dsb)',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '08',
                'jenis_claim' => 'Kejatuhan rambu/pohon/PJU/konstruksi jembatan',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '09',
                'jenis_claim' => 'Kegiatan pemeliharaan / proyek di wilayah jalan tol (pagar proyek yang tertabrak, rambu proyek, dsb)',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '10',
                'jenis_claim' => 'Pemasangan sarkapja (guardrail, rambu, dsb) yang tidak sesuai standar',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '11',
                'jenis_claim' => 'Keluhan terkait rest area',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
            [
                'code' => '10',
                'jenis_claim' => 'Kejatuhan konstruksi billboard / iklan',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
            [
                'code' => '9999',
                'jenis_claim' => 'Lain-lain',
                'unit_id' => null,
                'active' => 1
            ]
        ];
        // MasterJenisClaim::insert($array);
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        foreach($array as $k => $value){
            $record = MasterUnit::where('unit',$value['unit_id'])->first();

            if($record){
                $value['unit_id'] = $record->id;
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            MasterJenisClaim::create($value);
        }
    }
}
