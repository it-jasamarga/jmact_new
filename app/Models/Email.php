<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\GenerateUuid;

class Email extends Model implements Auditable 
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use GenerateUuid;
    use SoftDeletes;
    
    protected $fillable = [
        'id',
		'subject',
        'email',
        'message',
        'status'
    ];

}
