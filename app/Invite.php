<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'invites';

    protected $primaryKey = 'systemId';

    public $incrementing = false;

    protected $fillable = [
        'systemId',
        'email',
        'name',
        'token',
        'tenantId',
        'userId',
        'usergroupId'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class, 'systemId');
    }

    public function inviter() {
        return $this->belongsTo(User::class, 'systemId');
    }

    public function usergroupId() {
        return $this->belongsTo(UserGroup::class, 'systemId');
    }
}
