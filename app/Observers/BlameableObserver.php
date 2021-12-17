<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BlameableObserver
{
    public function creating(Model $model)
    {
        if(Schema::hasColumn($model->getTable(), 'created_by')){
            $model->created_by = (Auth::check()) ? Auth::user()->id : null;
        }
        
        // if(Schema::hasColumn($model->getTable(), $model->updated_by)){
        //     $model->updated_by = (Auth::check()) ? Auth::user()->id : null;
        // }
 
    }

    public function updating(Model $model)
    {
        if(Schema::hasColumn($model->getTable(), 'updated_by')){
            $model->updated_by = (Auth::check()) ? Auth::user()->id : null;
        }
    }
}
