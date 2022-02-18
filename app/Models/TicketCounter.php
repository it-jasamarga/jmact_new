<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class TicketCounter extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'source', 'unit', 'year', 'index'];

    // Kode Keluhan : C
    // Kode Sumber : A
    // Kode Unit : 01
    // Kode Tahun : 22 (2022)
    // Urutan Masuk Claim : 1

    public function reserve($description, $type, $source, $unit, $year = null, $field = 'no_tiket') {
        $return = ['result' => false];

        // $counter = new TicketCounter();
        $year = $year ?? date("Y")*1;
        $year = $year % 1000;

        DB::beginTransaction();
        try {
            $query = null;
            $safe_loop = 0;
            while ($safe_loop < 3) {
                $query = TicketCounter::where('type', $type)->where('source', $source)->where('unit', $unit)->where('year', $year)->lockForUpdate()->first(['index']);
                if (is_null($query)) {
                    $record = ['type' => $type, 'source' => $source, 'unit' => $unit, 'year' => $year, 'index' => 1];
                    TicketCounter::create($record);
                } else {
                    $index = $query->index;
                    $query = TicketCounter::where('type', $type)->where('source', $source)->where('unit', $unit)->where('year', $year)->lockForUpdate()->first();
                    $record = ['index' => $index+1];
                    $query->update($record);
                    $serial = $type.$source.$unit.$year.str_pad($index, 4, '0', STR_PAD_LEFT);
                    // dd($query, $record, $serial);
                    $record = ['number' => $serial, 'description' => $description];
                    TicketRegister::create($record);
                    DB::commit();
                    $return['result'] = true;
                    $return['data']['no_tiket'] = $serial;
                    break;
                }
                $safe_loop++;
            }
            if ($safe_loop>1) {
                DB::rollback();
                $return['result'] = false;
            }
        } catch(Exception $e) {
            DB::rollback();
            $return['exception'] = $e;
        }

        return $return;
    }
}
