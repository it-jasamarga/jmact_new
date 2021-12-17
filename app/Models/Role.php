<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Spatie\Permission\Models\Role as RoleModel;
use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\GenerateUuid;
use App\Traits\Utilities;

class Role extends RoleModel implements Auditable 
{
	use \OwenIt\Auditing\Auditable;
	use Utilities;
     
   	protected $table = 'roles';
	protected $guard_name = 'web';
 	protected $fillable = ['name', 'name_alias', 'guard_name'];
}
