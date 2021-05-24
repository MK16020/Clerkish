<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;

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

    public function childAccounts()
    {
        return $this->hasMany(Account::class, 'parentID');
    }

    public function baseAccount()
    {
        if ($this->parentID) {
            if ($this->parentAccount->parentID) {
                return $this->parentAccount->baseAccount();
            }
            return $this->parentAccount();
        }
    }

    public function journals()
    {
        return $this->BelongsToMany(
            DailyJournal::class,
            'accounts_journals',
            'accountID',
            'journalID'
        )->withPivot(['credit','debit','statment']);
    }

}
