<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use OwenIt\Auditing\Contracts\Auditable;

class KeluhanPelanggan extends Model implements Auditable
{
   	use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
	
    protected $table = 'keluhan';
 	protected $guarded = [];

	public function filesMorphClass()
	{
		return 'KeluhanPelanggan';
	}

	public function sumber(){
		return $this->belongsTo(MasterSumber::class,'sumber_id');
	}
	public function bidang(){
		return $this->belongsTo(MasterBk::class,'bidang_id');
	}
	public function ruas(){
		return $this->belongsTo(MasterRuas::class,'ruas_id');
	}
	public function golongan(){
		return $this->belongsTo(MasterGolken::class,'golongan_id');
	}
	public function status(){
		return $this->belongsTo(MasterStatus::class,'status_id');
	}
	public function user(){
		return $this->belongsTo(User::class,'user_id');
	}

	public function mulaiSla(){
		return $this->hasMany(KeluhanSla::class,'keluhan_id');
	}

	public function report(){
		return $this->hasMany(KeluhanReport::class,'keluhan_id');
	}

	public function history(){
		return $this->hasMany(KeluhanHistory::class,'keluhan_id');
	}

	public function keluhanUnit(){
		return $this->hasMany(KeluhanUnit::class,'keluhan_id');
	}

	public function unit(){
		return $this->belongsTo(MasterUnit::class,'unit_id');
	}

}
