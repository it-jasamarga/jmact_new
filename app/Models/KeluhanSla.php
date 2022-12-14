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

class KeluhanSla extends Model implements Auditable
{
   	use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
	
	protected $table = 'keluhan_sla';
 	protected $guarded = [];

    public function keluhan(){
		return $this->belongsTo(KeluhanPelanggan::class,'keluhan_id');
	}
}
