<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Blameable;
use App\Traits\Utilities;
use App\Traits\GenerateUuid;

use App\Filters\Filterable;
use OwenIt\Auditing\Contracts\Auditable;

class ClaimPelanggan extends Model implements Auditable
{
    use HasFactory, Filterable, Blameable, Utilities;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'claim';
 	protected $guarded = [];

	public function filesMorphClass()
	{
		return 'ClaimPelanggan';
	}

	public function sumber(){
		return $this->belongsTo(MasterSumber::class,'sumber_id');
	}

	public function jenisClaim(){
		return $this->belongsTo(MasterJenisClaim::class,'jenis_claim_id');
	}

	public function ruas(){
		return $this->belongsTo(MasterRuas::class,'ruas_id');
	}

	public function unit(){
		return $this->belongsTo(MasterUnit::class,'unit_id');
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

	public function history(){
		return $this->hasMany(DetailHistory::class,'claim_id');
	}

    public function historyLast(){
		return $this->hasOne(DetailHistory::class,'keluhan_id')->orderByDesc('id');
	}

	public function checkStatus($code){
		$return = "false";
		$data = $this->history()->whereHas('status', function($q) use($code){
			$q->whereIn('code',[$code])->where('type', 2);
		})->first();
		if($data) {
			$return = "true";
		}
		return $return;
	}

    public function setUrlFileAttribute($attribute){
        $request = request();
        if($request->url_file && is_file($request->url_file)){
          $fileName = md5($request->url_file->getClientOriginalName().auth()->user()->id.''.strtotime('now')).'.'.$request->url_file->getClientOriginalExtension();
          $request->file('url_file')->storeAs('Claim', $fileName, 'public');
          $path = 'Claim/'.$fileName;
          $this->attributes['url_file'] = $path;
        }
    }
}
