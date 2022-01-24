<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\MasterBk;

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
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Penerangan Jalan Umum',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Perbaikan Jalan',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Perbaikan Gerbang Tol',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Longsor',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Banjir',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Jalan Amblas',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'K3 (Kesehatan dan Keselamatan Kerja)',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Scrapping Filling Overlay (SFO)',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rekonstruksi',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Penambahan Lajur Jalan',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Peningkatan Kapasitas Gerbang',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Renovasi Gerbang Tol',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Jembatan',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Lansekap',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Pengecatan termasuk proteksi',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Patching & Surface Dressing Jalan tol',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Saluran Jalan dan Jembatan Tol',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Sarana Penerangan Jalan Umum',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Perbaikan Sarana Penerangan Jalan Umum',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rumput di luar Area Gerbang Tol dan Kantor Cabang',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Kebersihan Jalan Tol dan Sekitar Jalan Tol',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Pertamanan di Wilayah Jalan Tol (Perwatan, Pendangiran dan Perapihan)',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Mekanikal & elektrikal di luar Area Gerbang Tol dan Kantor Cabang',
                'active' => 1
            ],
            [
                'bidang' => 'Konstruksi',
                'keluhan' => 'Rambu, Guard Rail dan Marka Jalan',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Kemacetan',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Keamanan dan Ketertiban',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Variable Message Sign',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Informasi Lalu Lintas',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pelayanan Petugas',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pelayanan PJR',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Pelayanan Derek',
                'active' => 1
            ],
            [
                'bidang' => 'Lalin',
                'keluhan' => 'Lain-lain Traffice Management',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Uang Kembalian',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'E-Toll / GTO / E-Pass',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Peralatan Transaksi',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Tanda Terima',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Antrian Gerbang',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Kebersihan Gerbang',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Lajur Tutup',
                'active' => 1
            ],
            [
                'bidang' => 'Transaksi',
                'keluhan' => 'Sikap Petugas',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'K3 (Kesehatan dan Keselamatan Kerja)',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Kondisi Jalan',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'ON/OFF Ramp',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Toilet',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Parkir',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Kendaraan',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Penerangan',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'SPBU',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Tempat Ibadah',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Tempat Makan dan Minum',
                'active' => 1
            ],
            [
                'bidang' => 'Rest Area',
                'keluhan' => 'Bengkel',
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Kondisi Obyek',
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Penempatan',
                'active' => 1
            ],
            [
                'bidang' => 'Iklan',
                'keluhan' => 'Penerangan Iklan',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Logistik',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Fasilitas Gerbang',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Fasilitas Gardu Tol',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'SDM dan Umum',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Penggunaan Lahan Jasamarga',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Kebijakan Perusahaan',
                'active' => 1
            ],
            [
                'bidang' => 'Lain-lain',
                'keluhan' => 'Lain-lain',
                'active' => 1
            ],
        ];
        MasterBk::insert($array);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}