<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use App\Models\ClaimPelanggan as ModelsClaimPelanggan;
use OwenIt\Auditing\Contracts\Auditable;


class ClaimReport extends Model
{
    use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;
	
	protected $table = 'claim_report';
 	protected $guarded = [];

	public function claim(){
		return $this->belongsTo(ModelsClaimPelanggan::class,'claim_id');
	}

	public function setUrlFileAttribute($attribute){
        $request = request();
        if($request->url_file && is_file($request->url_file)){
          $fileName = md5($request->url_file->getClientOriginalName().auth()->user()->id.''.strtotime('now')).'.'.$request->url_file->getClientOriginalExtension();
          $request->file('url_file')->storeAs('ClaimReport', $fileName, 'public');
          $path = 'ClaimReport/'.$fileName;
          $this->attributes['url_file'] = $path;
        }
    }
}
