<?php

namespace App\Models;

use App\Traits\RecordSignature;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Yadahan\AuthenticationLog\AuthenticationLogable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

use App\Traits\Utilities;
use Tymon\JWTAuth\Contracts\JWTSubject;
use JWTAuth;
use Auth;

class User extends Authenticatable implements Auditable, JWTSubject
{
    use \OwenIt\Auditing\Auditable;
    use Utilities;
    use HasFactory, HasRoles;
    use AuthenticationLogable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be append for arrays.
     *
     * @var array
     */
    protected $appends = [
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getToken(){
        return (\Auth::check()) ? JWTAuth::fromUser(auth()->user()) : '';
    }

    public function profile()
    {
        return $this->belongsTo('App\Models\Profile','id','user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_users', 'user_id', 'role_id');
    }

    public function bugReport()
    {
        return $this->hasMany('App\Models\BugReporting');
    }

    public function unit(){
        return $this->belongsTo(MasterUnit::class,'unit_id');
    }
}
