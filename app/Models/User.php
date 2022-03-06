<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Invoice\TaskUser;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public const STATUS_ADMIN = 'admin';
    public const STATUS_USER = 'user';
    public const STATUS_DELETED = 'deleted';
    public const STATUS_MANAGER = 'manager';

    protected $fillable = [
        'img',
        'name',
        'email',
        'password',
        'status',
        'categoryStructure_id',
        'position'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function taskUsers() {
        return $this->hasMany(TaskUser::class, 'user_id', 'id')->with('users');
    }
}
