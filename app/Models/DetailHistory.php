<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use App\Http\Resources\KeluhanPelangganCollection;
use App\Models\KeluhanPelanggan as ModelsKeluhanPelanggan;
use OwenIt\Auditing\Contracts\Auditable;

class DetailHistory extends Model implements Auditable
{
   	use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
	
	protected $table = 'detail_history';
 	protected $guarded = [];

	public function ruas(){
		return $this->belongsTo(MasterRuas::class,'ruas_id');
	}

    public function keluhan(){
		return $this->belongsTo(KeluhanPelanggan::class,'keluhan_id');
	}

	public function status(){
		return $this->belongsTo(MasterStatus::class,'status_id');
	}

	public function user(){
		return $this->belongsTo(User::class,'created_by');
	}

	public function unit(){
		return $this->belongsTo(MasterUnit::class,'unit_id');
	}
}
