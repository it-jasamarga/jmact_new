<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Filters\Filterable;

class Cartik extends Model
{
    use HasFactory, Filterable;

	public function status(){
		return $this->belongsTo(MasterStatus::class,'status_id');
	}
}
