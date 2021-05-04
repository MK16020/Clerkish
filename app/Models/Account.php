<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use SoftDeletes;

    protected $casts = [
        'accountCode' => 'integer',
    ];

    protected $hidden = [
        'name_j',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = [
        'name',
    ];
}
