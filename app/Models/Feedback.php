<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    public function pelanggan() {
		$ret = strtoupper($this->no_tiket[0]) == "K" ?
            $this->hasOne(KeluhanPelanggan::class, 'no_tiket', 'no_tiket')
        :
            $this->hasOne(ClaimPelanggan::class, 'no_tiket', 'no_tiket');

        return $ret;
	}
}
