<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory, SoftDeletes;

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

    public function childAccount()
    {
        return $this->belongsTo(Account::class, 'childID');
    }

    public function lastChild()
    {
        return $this->hasMany(Account::class, 'lastChildID');
    }

    public function journal()
    {
        return $this->hasMany(DailyJournal::class, 'journalID');
    }
/*
* journals.
* childAccount
* parentAccount
 */
}
