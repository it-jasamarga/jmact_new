<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use App\Models\KeluhanPelanggan as ModelsKeluhanPelanggan;
use OwenIt\Auditing\Contracts\Auditable;

class DetailReport extends Model implements Auditable
{
   	use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
	
	protected $table = 'detail_report';
 	protected $guarded = [];

	public function keluhan(){
		return $this->belongsTo(ModelsKeluhanPelanggan::class,'keluhan_id');
	}

	public function setUrlFileAttribute($attribute){
        $request = request();
        if($request->url_file && is_file($request->url_file)){
          $fileName = md5($request->url_file->getClientOriginalName().auth()->user()->id.''.strtotime('now')).'.'.$request->url_file->getClientOriginalExtension();
          $request->file('url_file')->storeAs('DetailReport', $fileName, 'public');
          $path = 'DetailReport/'.$fileName;
          $this->attributes['url_file'] = $path;
        }
    }
}
