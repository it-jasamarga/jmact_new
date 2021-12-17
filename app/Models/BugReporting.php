<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Tylercd100\LERN\Models\ExceptionModel;

class BugReporting extends ExceptionModel {

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
