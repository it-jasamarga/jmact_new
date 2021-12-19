<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use OwenIt\Auditing\Contracts\Auditable;

class Notification extends Model implements Auditable
{
   	use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
    
	// protected $table = 'master_unit';

 	protected $guarded = [];


}
