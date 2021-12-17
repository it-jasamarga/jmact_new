<?php
namespace App\Traits;
use Webpatser\Uuid\Uuid;
use Auth;
use Facades\Str;
/**
 *
 */
trait GenerateUuid
{

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      $model->keyType = 'string';
      $model->incrementing = false;
      if(Auth::check()){
        $model->created_by = Auth::User()->id;
      }
      $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: (string) Str::orderedUuid();
    });

    static::updating(function ($model) {
        if(Auth::check()){
          $model->updated_by = Auth::User()->id;
        }
    });
  }

  public function getIncrementing()
  {
    return false;
  }

  public function getKeyType()
  {
    return 'string';
  }

}
