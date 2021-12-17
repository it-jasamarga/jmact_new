<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUuid;
use App\Filters\Filterable;
use App\Helpers\HelperFirestore;

class File extends Model
{
  use GenerateUuid;
  use Filterable;

  public $incrementing = false;
  protected $table = 'files';
  protected $keyType = 'string';
  protected $guarded = [];

  protected $fillable = [
    'id',
    'target_id',
    'target_type',
    'has_relation_id',
    'has_relation_type',
    'name',
    'extension',
    'url',
    'type',
  ];

  public function target()
  {
      return $this->morphTo();
  }

  public function hasRelation(){
      return $this->morphTo();
  }
  
  public function sendFire(){
    $data = $this->toArray();
    $data['id'] = isset($this->id) ? $this->id : $this->id;
    $data['registered_village_id'] = auth()->user()->registered_village_id;
    $db = 'Files';
    $record = HelperFirestore::sendDB($data,$db);
  }

  public function sendUpdtFire(){
    $data = $this->toArray();
    $data['id'] = isset($this->id) ? $this->id : $this->id;
    $data['registered_village_id'] = auth()->user()->registered_village_id;
    $db = 'Files';
    $record = HelperFirestore::sendUpdtDB($data,$db); 
  }
}
