<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use OwenIt\Auditing\Contracts\Auditable;

class MasterRo extends Model implements Auditable
{
   	use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
    
	protected $table = 'master_ro';

 	protected $guarded = [];

	 
	public function regional(){
		return $this->belongsTo(MasterRegional::class, 'regional_id');
	}
}
