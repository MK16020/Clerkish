<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'active'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean'
    ];

    protected $appends = [
        'role_name'
    ];

    public function getRoleNameAttribute()
    {
        return __('userMessages.roles.' . $this->role);
    }
}
