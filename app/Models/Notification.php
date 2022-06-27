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

	protected $table = 'notifications';

 	protected $guarded = [];

     public function user(){
		return $this->belongsTo(User::class,'user_id');
	}

    public function unit(){
		return $this->belongsTo(MasterUnit::class,'unit_id');
	}

}
