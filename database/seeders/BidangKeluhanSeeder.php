<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MasterBk;
use App\Models\MasterUnit;
use Facades\Str;
use DB;

class BidangKeluhanSeeder extends Seeder
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
        MasterBk::truncate();

        $array = [
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Lubang',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Penerangan Jalan Umum',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Perbaikan Jalan',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Perbaikan Gerbang Tol',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Longsor',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Banjir',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Jalan Amblas',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'K3 (Kesehatan dan Keselamatan Kerja) pada proyek pemeliharaan',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Scrapping Filling Overlay (SFO)',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rekonstruksi',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Penambahan Lajur Jalan',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Peningkatan Kapasitas Gerbang',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Renovasi Gerbang Tol',
                'tipe_layanan_keluhan' => 'Pemeliharaan/Operational',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Jembatan',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Lansekap',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Pengecatan termasuk proteksi sarkapja diluar area gerbang tol',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Pengecatan termasuk proteksi sarkapja di area gerbang tol',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Patching & Surface Dressing Jalan tol',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Saluran Jalan dan Jembatan Tol',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Sarana Penerangan Jalan Umum',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Perbaikan Sarana Penerangan Jalan Umum',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rumput di luar Area Gerbang Tol dan Kantor Cabang',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Kebersihan Jalan Tol dan Sekitar Jalan Tol',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Pertamanan di Wilayah Jalan Tol (Perwatan, Pendangiran dan Perapihan)',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Mekanikal & elektrikal di luar Area Gerbang Tol dan Kantor Cabang',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Mekanikal & elektrikal di Area Gerbang Tol dan Kantor Cabang',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rambu, Guard Rail dan Marka Jalan',
                'tipe_layanan_keluhan' => 'Pemeliharaan',
                'unit_id' => 'JMTM',
                'sla' => 168,
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rambu, Guard Rail dan Marka Jalan di area Gerbang Tol',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Kemacetan',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Keamanan dan Ketertiban',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Variable Message Sign',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Informasi Lalu Lintas',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pelayanan Petugas',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pelayanan PJR',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pelayanan Derek',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pekerjaan pemasangan/pemeliharaan sisinfokom (CCTV, VMS, FO, dll.)',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Lain-lain Traffice Management',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Uang Kembalian',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'E-Toll / GTO / E-Pass',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Peralatan Transaksi',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Tanda Terima',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Antrian Gerbang',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Kebersihan Gerbang',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Lajur Tutup',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Sikap Petugas Transaksi dan Lalin',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Sikap Petugas TIP',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'K3 (Kesehatan dan Keselamatan Kerja) di TI/TIP',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Kondisi Jalan di TI/TIP',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'ON/OFF Ramp di TI/TIP',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Toilet',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Parkir',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Kendaraan',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Penerangan',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'SPBU',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Tempat Ibadah',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Tempat Makan dan Minum',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Bengkel',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Kondisi Obyek',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Penempatan',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Penerangan Iklan',
                'tipe_layanan_keluhan' => 'Usaha lain',
                'unit_id' => 'JMRB',
                'sla' => 48,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Logistik',
                'tipe_layanan_keluhan' => 'Operational/Pemeliharaan/Usaha Lain/Korporasi',
                'unit_id' => 'JMRB',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Fasilitas Gerbang',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Fasilitas Gardu Tol',
                'tipe_layanan_keluhan' => 'Operational',
                'unit_id' => 'JMTO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'SDM dan Umum',
                'tipe_layanan_keluhan' => 'Operational/Pemeliharaan/Usaha Lain/Korporasi',
                'unit_id' => 'JMRB',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Penggunaan Lahan Jasamarga',
                'tipe_layanan_keluhan' => 'Operational/Pemeliharaan/Usaha Lain/Korporasi',
                'unit_id' => 'JMRB',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Kebijakan Perusahaan',
                'tipe_layanan_keluhan' => 'Korporasi',
                'unit_id' => 'CCO',
                'sla' => 72,
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Lain-lain',
                'tipe_layanan_keluhan' => 'Operational/Pemeliharaan/Usaha Lain/Korporasi',
                'unit_id' => 'JMRB',
                'sla' => 72,
                'active' => 1
            ],
        ];
        foreach($array as $k => $value){
            $record = MasterUnit::where('unit',$value['unit_id'])->first();

            if($record){
                $value['unit_id'] = $record->id;
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            MasterBk::create($value);
        }

    }
}
