<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;
use App\Filters\Filterable;
use App\Traits\GenerateUuid;
use App\Traits\Utilities;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportContent extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use GenerateUuid,Filterable,Utilities;
    use SoftDeletes;

    protected $table = 'reportContents';
    protected $guarded = [];

    public $rules = [
        
	];

    protected $fillable = [
        'name',
        'description',
        'fileurl',
    ];

    public function filesMorphClass()
    {
        return 'ReportContent';
    }

    public function files()
    {
        return $this->morphMany('App\Models\File', 'target');
    }

    public function fileOne()
    {
        return $this->morphOne('App\Models\File', 'target')->orderBy('created_at','desc');
    }

    
   
}
