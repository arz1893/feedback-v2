<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'systemId',
        'name',
        'email',
        'password',
        'phone',
        'usergroupId',
        'tenantId',
        'userKey',
        'active',
        'status',
        'syscreator',
        'syslastupdater',
        'sysdeleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenantId', 'systemId');
    }

    public function user_group() {
        return $this->belongsTo(UserGroup::class, 'usergroupId', 'systemId');
    }

    public function invites() {
        return $this->hasMany(Invite::class);
    }
}
