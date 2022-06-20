<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class SysLog extends Model
{
    use HasFactory;
    protected $fillable = ['log', 'client', 'created_by'];

    public function write($log) {
        self::create([
            'log'           => $log,
            'client'        => request()->ip() ." ". request()->header('user-agent'),
            'created_by'    => request()->user()->id ?? 0
        ]);
    }
}
