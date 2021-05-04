<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $casts = [
        'accountCode' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $appends = [
        'name',
    ];
    public function parentAccount()
    {
        return $this->belongsTo(Account::class, 'parentID');
    }

    public function lastChild()
    {
        return $this->hasMany(Account::class, 'lastChildID');
    }

}
