<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\Sanctum;

class DailyJournal extends Model
{
    use HasFactory;

    protected $casts = [
        'number' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function accounts()
    {
        return $this->BelongsToMany(
            Account::class,
            'accounts_journals',
            'journalID',
            'accountID'
        )->withPivot(['credit','debit','statment']);
    }

    public function getCreditAttribute()
    {
        $credit = 0;
        $accounts = $this->accounts;

        foreach( $accounts as $account){
            $credit += $account->pivot->credit;
        }

        return $credit;
    }
    public function getDebitAttribute()
    {
        $debit=0;
        $accounts = $this->accounts;

        foreach( $accounts as $account){
            $debit += $account->pivot->debit;
        }
        return $debit;
    }
    public function getAdjustmentAttribute()
    {
        return $this->credit - $this->debit;
    }
}
