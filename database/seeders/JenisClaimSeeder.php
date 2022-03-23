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
                'jenis_claim' => 'Rambu portal di gerbang tol',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '02',
                'jenis_claim' => 'Sarana dan prasarana di gerbang tol',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '03',
                'jenis_claim' => 'Kejatuhan ALB',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '04',
                'jenis_claim' => 'Kelebihan pemotongan saldo',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '05',
                'jenis_claim' => 'Kesalahan deteksi golongan',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '06',
                'jenis_claim' => 'Pengaturan lalu lintas',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '07',
                'jenis_claim' => 'Pentalan material',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '08',
                'jenis_claim' => 'Rintangan di jalan tol (batu, balok, besi)',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '09',
                'jenis_claim' => 'Pelemparan Batu',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '10',
                'jenis_claim' => 'Gangguan orang gila/hewan',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '11',
                'jenis_claim' => 'Naik turun Penumpang',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '12',
                'jenis_claim' => 'Lainnya yang termasuk lingkup pengoperasian jalan tol',
                'unit_id' => 'JMTO',
                'active' => 1
            ],
            [
                'code' => '13',
                'jenis_claim' => 'Lubang',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '14',
                'jenis_claim' => 'Gundukan Aspal',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '15',
                'jenis_claim' => 'Genangan Air',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '16',
                'jenis_claim' => 'Pohon tumbang',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '17',
                'jenis_claim' => 'Kerusakan rambu di lajur',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '18',
                'jenis_claim' => 'Kerusakan PJU',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '19',
                'jenis_claim' => 'Konstruksi jembatan',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '20',
                'jenis_claim' => 'Kegiatan pemeliharaan',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '21',
                'jenis_claim' => 'Pagar/Rambu proyek',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '22',
                'jenis_claim' => 'Sarkapja (guardrail, rambu, marka, dll.)',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '23',
                'jenis_claim' => 'Lainnya yang termasuk lingkup pemeliharaan jalan tol',
                'unit_id' => 'JMTM',
                'active' => 1
            ],
            [
                'code' => '24',
                'jenis_claim' => 'Konstruksi billboard/iklan',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
            [
                'code' => '25',
                'jenis_claim' => 'keluhan terkait rest area',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
            [
                'code' => '26',
                'jenis_claim' => 'Lubang di rest area',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
            [
                'code' => '27',
                'jenis_claim' => 'Genangan Air di rest area',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
            [
                'code' => '28',
                'jenis_claim' => 'Lainnya yang termasuk lingkup pengelolaan rest area',
                'unit_id' => 'JMRB',
                'active' => 1
            ],
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
