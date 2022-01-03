<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use OwenIt\Auditing\Contracts\Auditable;

class ClaimHistory extends Model implements Auditable
{
    use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
	
	protected $table = 'claim_history';
 	protected $guarded = [];

	public function ruas(){
		return $this->belongsTo(MasterRuas::class,'ruas_id');
	}

    public function claim(){
		return $this->belongsTo(ClaimPelanggan::class,'claim_id');
	}

	public function status(){
		return $this->belongsTo(MasterStatus::class,'status_id');
	}
}
